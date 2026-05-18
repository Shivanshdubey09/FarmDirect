# 🌾 FarmDirect — Bulk Agribusiness & AI Marketplace

> Direct, premium, and decentralized B2B procurement from verified sustainable farms. Powered by AI and designed for rural and corporate efficiency.

---

## 🚀 The Vision

**FarmDirect** is a state-of-the-art, bulk agricultural marketplace designed to bypass middlemen and connect farmers directly with commercial buyers (restaurants, retail chains, food processors, and exporters). 

The platform blends cutting-edge visual aesthetics (sleek dark mode, bento-grid modules, smooth micro-animations, and glassmorphism) with highly robust backend architecture to deliver a seamless trading experience for both parties.

---

## 🛠️ Technology Stack

*   **Core Framework**: Laravel 11 (PHP)
*   **Database**: MongoDB (NoSQL database connection via Eloquent for highly flexible crop catalogs, chats, bids, and notifications)
*   **Styling & Design System**: Modern custom Tailwind CSS (integrated with an offline, high-speed Play CDN compilation engine to bypass network and SSL blocks)
*   **Aesthetics & Typography**: Outfit, Plus Jakarta Sans, and Manrope fonts paired with Google Material Design Symbols
*   **File Storage**: Local filesystem storage with symbolic linking for custom user avatars and quality-crop photo uploads

---

## ✨ Core Features

### 🚜 1. Dual-Role Specialized Dashboards
*   **Farmer Hub**: Manage listings, monitor active crop bids, track incoming logistics, and interact with the AI assistant.
*   **Buyer Portal**: Discover fresh crops, browse the asymmetric bento-grid marketplace, save listings, bid on active bulk harvests, and download PDF invoices.

### 🤖 2. Mandi AI Price Assistant (FarmBot)
*   Integrates interactive, real-time AI price recommendation widgets.
*   Pulls up-to-date regional Mandi prices and evaluates bulk quality levels to suggest optimal listing and bidding prices.

### 💬 3. Real-Time Chat & Collaboration
*   Direct buyer-to-farmer live messaging system built into the dashboard.
*   Bypasses phone calls, allowing instant negotiations, custom photo sharing, and terms agreements directly inside a clean, modern interface.

### 📸 4. Intelligent Crop Image Engine
*   **Model-Level Accessor**: Centralized resolving engine built directly into the `Crop` Eloquent model.
*   **Farmer Custom Uploads**: Supports physical upload of quality images, dynamically processed, stored, and routed via secure local public storage.
*   **Curated Keyword Mappings**: Contains a handpicked catalog of **60+ premium crop varieties** (e.g. Wheat, Basmati Rice, Guava, Sugarcane, Tomato, Cabbage, Ginger, etc.). If no custom image is uploaded, it auto-resolves to a matched, high-fidelity Unsplash photo.

### ⚖️ 5. Bidding & Order Logistics
*   Enables buyers to place competitive bids on bulk crop listings.
*   Includes step-by-step logistics progress bars, tracking, and structured PDF invoice generation.

### 🔒 6. Interactive Guardrails & Modals
*   Premium glassmorphic modal popups for **Terms & Conditions** and **Privacy Policy** during registration.
*   Seamless profile picture upload persistence and dynamic system-wide navbar avatar rendering.

---

## 👨‍💻 Core Team

*   **Shivansh Dubey** — *Full Stack Developer & Technical Lead*
*   **Saakshi Jha** — *Frontend Architect & UX Designer*
*   **Rishabh Chaurasia** — *Backend Engineer & Database Administrator*

---

## 🔧 Installation & Local Setup

Follow these simple steps to run the application locally on your machine:

### 1. Clone the repository
```bash
git clone https://github.com/Shivanshdubey09/FarmDirect.git
cd FarmDirect
```

### 2. Install dependencies
```bash
composer install
npm install
```

### 3. Setup environment variables
Copy the example environment file and configure your database settings:
```bash
cp .env.example .env
```
Make sure to configure your MongoDB connection credentials in your `.env` file:
```env
DB_CONNECTION=mongodb
DB_HOST=127.0.0.1
DB_PORT=27017
DB_DATABASE=farmdirect
```

### 4. Create storage symlink
Ensure uploaded crop images and avatars are accessible:
```bash
php artisan storage:link
```

### 5. Launch the local servers
Run the development server:
```bash
php artisan serve
```
Open your browser and navigate to `http://127.0.0.1:8000` to experience the premium interface!

---

## 📄 License
This project is open-sourced software licensed under the [MIT License](LICENSE).
