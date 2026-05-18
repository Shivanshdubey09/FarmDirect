<?php
namespace App\Models;
use MongoDB\Laravel\Eloquent\Model;

class Crop extends Model
{
    protected $connection = 'mongodb';
    protected $collection = 'crops';

    protected $fillable = [
        'farmer_id',
        'name',
        'variety',
        'category',
        'quantity',
        'unit',
        'price_per_unit',
        'harvest_date',
        'expiry_date',
        'image_url',
        'quality_image_url',
        'status', // active, sold, expired
        'is_organic',
        'description'
    ];

    protected $casts = [
        'quantity' => 'integer',
        'price_per_unit' => 'float',
        'is_organic' => 'boolean',
    ];

    public function farmer()
    {
        return $this->belongsTo(User::class, 'farmer_id');
    }

    public function getImageUrlAttribute($value)
    {
        if ($value) {
            if (str_starts_with($value, 'http')) {
                return $value;
            }
            $cleanPath = ltrim($value, '/');
            if (str_starts_with($cleanPath, 'storage/')) {
                $cleanPath = substr($cleanPath, 8);
            }
            return asset('storage/' . $cleanPath);
        }
        
        $cropImages = [
            // Grains, Staples & Grains
            'basmati'            => 'photo-1586201375761-83865001e31c', // Basmati Rice
            'paddy'              => 'photo-1586201375761-83865001e31c', // Paddy
            'rice'               => 'photo-1586201375761-83865001e31c', // Rice
            'wheat'              => 'photo-1574323347407-f5e1ad6d020b', // Wheat
            'maize'              => 'photo-1551754655-cd27e38d2076', // Maize
            'corn'               => 'photo-1551754655-cd27e38d2076', // Corn
            'barley'             => 'photo-1574323347407-f5e1ad6d020b', // Barley
            'oats'               => 'photo-1586201375761-83865001e31c', // Oats
            'millet'             => 'photo-1574323347407-f5e1ad6d020b', // Millet
            'bajra'              => 'photo-1574323347407-f5e1ad6d020b', // Bajra
            'jowar'              => 'photo-1574323347407-f5e1ad6d020b', // Jowar
            'quinoa'             => 'photo-1586201375761-83865001e31c', // Quinoa

            // Pulses, Dal & Legumes
            'rajma'              => 'photo-1542990253-0d0f5be5f0ed', // Rajma
            'pulse'              => 'photo-1542990253-0d0f5be5f0ed', // Pulses
            'chickpea'           => 'photo-1542990253-0d0f5be5f0ed', // Chickpea
            'chana'              => 'photo-1542990253-0d0f5be5f0ed', // Chana
            'lentil'             => 'photo-1542990253-0d0f5be5f0ed', // Lentils
            'masoor'             => 'photo-1542990253-0d0f5be5f0ed', // Masoor
            'moong'              => 'photo-1542990253-0d0f5be5f0ed', // Moong
            'urad'               => 'photo-1542990253-0d0f5be5f0ed', // Urad
            'toor'               => 'photo-1542990253-0d0f5be5f0ed', // Toor
            'dal'                => 'photo-1542990253-0d0f5be5f0ed', // Dal
            'soybean'            => 'photo-1599940824399-b87987ceb72a', // Soybean
            'groundnut'          => 'photo-1542990253-0d0f5be5f0ed', // Groundnut
            'peanut'             => 'photo-1542990253-0d0f5be5f0ed', // Peanut
            'pea'                => 'photo-1587049352846-4a222e784d38', // Peas
            'beans'              => 'photo-1571770095004-6b61b1cf308a', // Beans

            // Fruits
            'apple'              => 'photo-1567306226416-28f0efdc88ce', // Apple
            'banana'             => 'photo-1571771894821-ce9b6c11b08e', // Banana
            'guava'              => 'photo-1600788907416-456578634209', // Guava
            'sugarcane'          => 'photo-1528183429752-a97d0bf99b5a', // Sugarcane
            'chiku'              => 'photo-1621460245084-2e6524b7a956', // Chiku / Sapodilla
            'sapodilla'          => 'photo-1621460245084-2e6524b7a956', // Sapodilla
            'orange'             => 'photo-1547514701-42782101795e', // Orange
            'mango'              => 'photo-1553279768-865429fa0078', // Mango
            'grapes'             => 'photo-1537640538966-79f369143f8f', // Grapes
            'pomegranate'        => 'photo-1615485290382-441e4d049cb5', // Pomegranate
            'strawberry'         => 'photo-1464965911861-746a04b4bca6', // Strawberry
            'papaya'             => 'photo-1526318896980-cf78c088247c', // Papaya
            'watermelon'         => 'photo-1563114773-84221bd62daa', // Watermelon
            'pineapple'          => 'photo-1550258987-190a2d41a8ba', // Pineapple
            'litchi'             => 'photo-1566132133282-8c0a28e15294', // Litchi
            'peach'              => 'photo-1595124253363-c595018e67a0', // Peach
            'pear'               => 'photo-1514756331096-242fdeb70d4a', // Pear
            'plum'               => 'photo-1603058866504-209673998b3c', // Plum
            'coconut'            => 'photo-1546527868-ccde8624d895', // Coconut

            // Vegetables, Herbs & Spices
            'potato'             => 'photo-1518977676601-b53f82aba655', // Potato
            'onion'              => 'photo-1518977956812-cd3dbadaaf31', // Onion
            'tomato'             => 'photo-1595855759920-86582396756a', // Tomato
            'red chilly'         => 'photo-1592924357228-91a4daadcfea', // Red Chilli
            'red chili'          => 'photo-1592924357228-91a4daadcfea', // Red Chili
            'green chilly'       => 'photo-1588252399616-921473775b8e', // Green Chilli
            'green chili'        => 'photo-1588252399616-921473775b8e', // Green Chili
            'chilly'             => 'photo-1588252399616-921473775b8e', // Chilly
            'chili'              => 'photo-1588252399616-921473775b8e', // Chili
            'sarson'             => 'photo-1534073828943-f801091bb18c', // Sarson / Mustard greens
            'mustard'            => 'photo-1534073828943-f801091bb18c', // Mustard
            'ladiesfinger'       => 'photo-1601309587222-295328f96e9d', // Ladiesfinger
            'ladies finger'      => 'photo-1601309587222-295328f96e9d', // Ladies finger
            'okra'               => 'photo-1601309587222-295328f96e9d', // Okra
            'bhindi'             => 'photo-1601309587222-295328f96e9d', // Bhindi
            'carrot'             => 'photo-1582515073490-39981397c445', // Carrot
            'lemon'              => 'photo-1608686207856-001b95cf60ca', // Lemon
            'spinach'            => 'photo-1576045057995-568f588f82fb', // Spinach
            'cabbage'            => 'photo-1597362925123-77861d3fbac7', // Cabbage
            'cauliflower'        => 'photo-1591343395082-e120087004b4', // Cauliflower
            'garlic'             => 'photo-1540148426945-6cf22a6b2383', // Garlic
            'ginger'             => 'photo-1599940824399-b87987ceb72a', // Ginger
            'turmeric'           => 'photo-1615485290382-441e4d049cb5', // Turmeric
            'pepper'             => 'photo-1588252399616-921473775b8e', // Pepper
            'brinjal'            => 'photo-1587132137056-bfbf0166836e', // Brinjal
            'eggplant'           => 'photo-1587132137056-bfbf0166836e', // Eggplant
            'pumpkin'            => 'photo-1570586437263-ab629fccc818', // Pumpkin
            'cucumber'           => 'photo-1551877781-1c12ea7a9acd', // Cucumber
            'kheera'             => 'photo-1551877781-1c12ea7a9acd', // Kheera
            'capsicum'           => 'photo-1518779578993-ec3579fee39f', // Capsicum
            'radish'             => 'photo-1598170845058-32b9d6a5da37', // Radish
            'beetroot'           => 'photo-1587049332298-1c42e83937a7', // Beetroot
            'turnip'             => 'photo-1598170845058-32b9d6a5da37', // Turnip
            'cotton'             => 'photo-1594489428504-5c0c480a15fd', // Cotton
            'sunflower'          => 'photo-1597848212624-a19eb35e2651', // Sunflower
        ];

        $nameLower = strtolower($this->name ?? '');
        foreach ($cropImages as $keyword => $photoId) {
            if (str_contains($nameLower, $keyword)) {
                return "https://images.unsplash.com/{$photoId}?auto=format&fit=crop&q=80&w=800";
            }
        }
        
        return 'https://images.unsplash.com/photo-1500937386664-56d1dfef3854?auto=format&fit=crop&q=80&w=800';
    }
}
