<?php

/**
 * Get a destination image URL from Unsplash based on the name and location
 * 
 * @param string $name The destination name
 * @param string $location The destination location
 * @return string The image URL
 */
function getDestinationImageUrl($name, $location) {
    // Map of popular destinations to specific high-quality image URLs
    $imageMap = [
        'Paris' => 'https://images.unsplash.com/photo-1502602898657-3e91760cbb34?ixlib=rb-4.0.3&auto=format&fit=crop&w=1200&q=80',
        'London' => 'https://images.unsplash.com/photo-1513635269975-59663e0ac1ad?ixlib=rb-4.0.3&auto=format&fit=crop&w=1200&q=80',
        'New York' => 'https://images.unsplash.com/photo-1496442226666-8d4d0e62e6e9?ixlib=rb-4.0.3&auto=format&fit=crop&w=1200&q=80',
        'Tokyo' => 'https://images.unsplash.com/photo-1536098561742-ca998e48cbcc?ixlib=rb-4.0.3&auto=format&fit=crop&w=1200&q=80',
        'Rome' => 'https://images.unsplash.com/photo-1525874684015-58379d421a52?ixlib=rb-4.0.3&auto=format&fit=crop&w=1200&q=80',
        'Barcelona' => 'https://images.unsplash.com/photo-1539037116277-4db20889f2d4?ixlib=rb-4.0.3&auto=format&fit=crop&w=1200&q=80',
        'Dubai' => 'https://images.unsplash.com/photo-1512453979798-5ea266f8880c?ixlib=rb-4.0.3&auto=format&fit=crop&w=1200&q=80',
        'Bali' => 'https://images.unsplash.com/photo-1537996194471-e657df975ab4?ixlib=rb-4.0.3&auto=format&fit=crop&w=1200&q=80',
        'Sydney' => 'https://images.unsplash.com/photo-1506973035872-a4ec16b8e8d9?ixlib=rb-4.0.3&auto=format&fit=crop&w=1200&q=80',
        'Marrakech' => 'https://images.unsplash.com/photo-1548234537-f96fdb3e4929?ixlib=rb-4.0.3&auto=format&fit=crop&w=1200&q=80', // Fixed URL for Marrakech
        'Bangkok' => 'https://images.unsplash.com/photo-1508009603885-50cf7c8dd0d5?ixlib=rb-4.0.3&auto=format&fit=crop&w=1200&q=80',
        'Istanbul' => 'https://images.unsplash.com/photo-1524231757912-21f4fe3a7200?ixlib=rb-4.0.3&auto=format&fit=crop&w=1200&q=80',
        'Rio de Janeiro' => 'https://images.unsplash.com/photo-1483729558449-99ef09a8c325?ixlib=rb-4.0.3&auto=format&fit=crop&w=1200&q=80',
        'Cape Town' => 'https://images.unsplash.com/photo-1576485375217-d6a95e37a889?ixlib=rb-4.0.3&auto=format&fit=crop&w=1200&q=80',
        'Venice' => 'https://images.unsplash.com/photo-1523906834658-6e24ef2386f9?ixlib=rb-4.0.3&auto=format&fit=crop&w=1200&q=80',
        'Amsterdam' => 'https://images.unsplash.com/photo-1512470876302-972faa2aa9a4?ixlib=rb-4.0.3&auto=format&fit=crop&w=1200&q=80',
        'Prague' => 'https://images.unsplash.com/photo-1519677100203-a0e668c92439?ixlib=rb-4.0.3&auto=format&fit=crop&w=1200&q=80',
        'Santorini' => 'https://images.unsplash.com/photo-1570077188670-e3a8d69ac5ff?ixlib=rb-4.0.3&auto=format&fit=crop&w=1200&q=80',
        'Kyoto' => 'https://images.unsplash.com/photo-1493976040374-85c8e12f0c0e?ixlib=rb-4.0.3&auto=format&fit=crop&w=1200&q=80',
        'Maldives' => 'https://images.unsplash.com/photo-1514282401047-d79a71a590e8?ixlib=rb-4.0.3&auto=format&fit=crop&w=1200&q=80',
    ];

    // Check if we have a specific image for this destination
    if (isset($imageMap[$name])) {
        return $imageMap[$name];
    }
    
    // Fallback: use Unsplash source for dynamic image based on name and location
    return "https://source.unsplash.com/1200x800/?{$name},{$location},travel,landmark";
}