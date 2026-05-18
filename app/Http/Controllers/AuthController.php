<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function showRegistrationForm()
    {
        return view('auth.register');
    }

    public function register(Request $request)
    {
        $request->validate([
            'name'     => 'required|string|max:255',
            'email'    => 'required|string|email|max:255',
            'password' => 'required|string|min:8|confirmed',
            'role'     => 'required|in:farmer,buyer',
            'city'     => 'required|string|max:255',
            'state'    => 'required|string|max:255',
            'pincode'  => 'required|string|max:20',
            'address'  => 'required|string|max:500',
        ]);

        $email        = $request->email;
        $selectedRole = $request->role;

        // One registration per email+role combination
        $alreadyExists = User::where('email', $email)
                             ->where('role', $selectedRole)
                             ->exists();

        if ($alreadyExists) {
            return back()
                ->withInput()
                ->withErrors([
                    'email' => "An account already exists for this email as a {$selectedRole}. Please log in instead."
                ]);
        }

        // Create independent account for this role
        User::create([
            'name'     => $request->name,
            'email'    => $email,
            'password' => Hash::make($request->password),
            'role'     => $selectedRole,
            'city'     => $request->city,
            'state'    => $request->state,
            'pincode'  => $request->pincode,
            'address'  => $request->address,
        ]);

        // Redirect to login with a success message
        return redirect('/login')->with('success', "Registration successful! You are now registered as a {$selectedRole}. Please log in below.");
    }

    // ─── Login ────────────────────────────────────────────────────────────────

    public function showLoginForm()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'email'    => 'required',
            'password' => 'required|string',
            'role'     => 'nullable|in:farmer,buyer',
        ]);

        $selectedRole = $request->role;

        // If no role is selected, attempt admin login
        if (empty($selectedRole)) {
            $user = User::where('email', $request->email)
                        ->where('role', 'admin')
                        ->first();

            if (!$user || !Hash::check($request->password, $user->password)) {
                return back()
                    ->withInput($request->only('email'))
                    ->withErrors(['email' => 'Invalid admin credentials. If you are a farmer or buyer, please select a role.']);
            }

            Auth::login($user, $request->boolean('remember'));
            return redirect('/dashboard/admin');
        }

        // Standard farmer/buyer login
        $user = User::where('email', $request->email)
                    ->where('role', $selectedRole)
                    ->first();

        if (!$user || !Hash::check($request->password, $user->password)) {
            return back()
                ->withInput($request->only('email', 'role'))
                ->withErrors(['email' => 'Invalid credentials for this role. Please check your email, role, and password.']);
        }

        // Check if account is suspended
        if ($user->is_suspended) {
            return back()
                ->withInput($request->only('email', 'role'))
                ->withErrors(['email' => 'Your account has been suspended by the platform administrator. Please contact support for assistance.']);
        }

        Auth::login($user, $request->boolean('remember'));

        return $selectedRole === 'farmer'
            ? redirect('/dashboard/farmer')
            : redirect('/dashboard/buyer');
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/login');
    }

    // ─── Forgot Password ──────────────────────────────────────────────────────

    public function sendResetOtp(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'role'  => 'required|in:farmer,buyer',
        ]);

        $user = User::where('email', $request->email)
                    ->where('role', $request->role)
                    ->first();

        if (!$user) {
            return response()->json([
                'success' => false,
                'message' => 'No account found with this email and role combination.'
            ]);
        }

        if ($user->is_suspended) {
            return response()->json([
                'success' => false,
                'message' => 'Your account is suspended. Password reset is not permitted.'
            ]);
        }

        $otp = rand(100000, 999999);
        $user->reset_otp = $otp;
        $user->reset_otp_expires_at = now()->addMinutes(10)->toDateTimeString();
        $user->save();

        // Log OTP locally for backend debugging
        \Log::info("Password Reset OTP for {$request->email} ({$request->role}): {$otp}");

        // Dispatch real email via SMTP using Gmail configurations
        try {
            \Illuminate\Support\Facades\Mail::raw(
                "Hello {$user->name},\n\n"
                . "You are receiving this email because you requested a password reset for your FarmDirect account under the role of " . ucfirst($request->role) . ".\n\n"
                . "Your 6-digit secure OTP verification code is: {$otp}\n\n"
                . "This code is valid for the next 10 minutes. If you did not request this password reset, please secure your account immediately.\n\n"
                . "Regards,\n"
                . "FarmDirect Security Division",
                function ($message) use ($user) {
                    $message->to($user->email)
                            ->subject('FarmDirect Password Reset OTP');
                }
            );
        } catch (\Exception $e) {
            \Log::error("Failed to dispatch password reset SMTP email to {$user->email}: " . $e->getMessage());
        }

        return response()->json([
            'success' => true,
            'otp'     => $otp,
            'message' => 'A 6-digit OTP code has been successfully generated and sent to your Gmail.'
        ]);
    }

    public function verifyResetOtp(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'role'  => 'required|in:farmer,buyer',
            'otp'   => 'required|numeric|digits:6',
        ]);

        $user = User::where('email', $request->email)
                    ->where('role', $request->role)
                    ->first();

        if (!$user) {
            return response()->json(['success' => false, 'message' => 'No account found.']);
        }

        $expiresAt = $user->reset_otp_expires_at ? \Carbon\Carbon::parse($user->reset_otp_expires_at) : null;

        if ($user->reset_otp !== $request->otp || !$expiresAt || $expiresAt->isPast()) {
            return response()->json([
                'success' => false,
                'message' => 'Invalid or expired OTP. Please try again.'
            ]);
        }

        return response()->json([
            'success' => true,
            'message' => 'OTP verified successfully.'
        ]);
    }

    public function resetPassword(Request $request)
    {
        $request->validate([
            'email'    => 'required|email',
            'role'     => 'required|in:farmer,buyer',
            'otp'      => 'required|numeric|digits:6',
            'password' => 'required|string|min:8|confirmed',
        ]);

        $user = User::where('email', $request->email)
                    ->where('role', $request->role)
                    ->first();

        if (!$user) {
            return response()->json(['success' => false, 'message' => 'No account found.']);
        }

        $expiresAt = $user->reset_otp_expires_at ? \Carbon\Carbon::parse($user->reset_otp_expires_at) : null;

        if ($user->reset_otp !== $request->otp || !$expiresAt || $expiresAt->isPast()) {
            return response()->json([
                'success' => false,
                'message' => 'Verification failed. OTP has expired or is invalid.'
            ]);
        }

        $user->password = Hash::make($request->password);
        $user->reset_otp = null;
        $user->reset_otp_expires_at = null;
        $user->save();

        return response()->json([
            'success' => true,
            'message' => 'Your password has been successfully updated!'
        ]);
    }
}


