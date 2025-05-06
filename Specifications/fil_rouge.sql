CREATE TABLE `activities` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `location` varchar(255) NOT NULL,
  `scheduled_at` datetime NOT NULL,
  `description` text DEFAULT NULL,
  `trip_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
)

INSERT INTO `activities` (`id`, `name`, `location`, `scheduled_at`, `description`, `trip_id`, `created_at`, `updated_at`) VALUES
(1, 'Eiffel Tower Visit', 'Eiffel Tower, Paris', '2025-06-07 10:00:00', 'Visit the iconic Eiffel Tower and enjoy panoramic views of Paris.', 1, '2025-05-06 09:28:56', '2025-05-06 09:28:56'),
(2, 'Louvre Museum Tour', 'Louvre Museum, Paris', '2025-06-08 10:00:00', 'Guided tour of the world-famous Louvre Museum, home to the Mona Lisa.', 1, '2025-05-06 09:28:56', '2025-05-06 09:28:56'),
(3, 'Seine River Cruise', 'Seine River, Paris', '2025-06-09 10:00:00', 'Romantic evening cruise along the Seine River with dinner.', 1, '2025-05-06 09:28:56', '2025-05-06 09:28:56'),
(4, 'Medina Exploration', 'Medina, Marrakech', '2024-06-16 10:00:00', 'Guided walk through the ancient Medina and its bustling souks.', 2, '2025-05-06 09:28:56', '2025-05-06 09:28:56'),
(5, 'Majorelle Garden Visit', 'Majorelle Garden, Marrakech', '2024-06-17 10:00:00', 'Visit the stunning blue Majorelle Garden and YSL Museum.', 2, '2025-05-06 09:28:56', '2025-05-06 09:28:56'),
(6, 'Desert Camel Ride', 'Agafay Desert, Marrakech', '2024-06-18 10:00:00', 'Sunset camel ride in the desert followed by traditional dinner.', 2, '2025-05-06 09:28:56', '2025-05-06 09:28:56'),
(7, 'Ubud Sacred Monkey Forest', 'Ubud, Bali', '2024-07-11 10:00:00', 'Visit the sacred monkey forest sanctuary with hundreds of monkeys.', 3, '2025-05-06 09:28:56', '2025-05-06 09:28:56'),
(8, 'Rice Terrace Trek', 'Tegallalang, Bali', '2024-07-12 10:00:00', 'Trek through the beautiful rice terraces of Tegallalang.', 3, '2025-05-06 09:28:56', '2025-05-06 09:28:56'),
(9, 'Tanah Lot Temple Sunset', 'Tanah Lot, Bali', '2024-07-13 10:00:00', 'Watch the sunset at the beautiful sea temple of Tanah Lot.', 3, '2025-05-06 09:28:56', '2025-05-06 09:28:56'),
(10, 'Eiffel Tower Visit', 'Eiffel Tower, Paris', '2024-08-06 10:00:00', 'Visit the iconic Eiffel Tower and enjoy panoramic views of Paris.', 4, '2025-05-06 09:28:56', '2025-05-06 09:28:56'),
(11, 'Louvre Museum Tour', 'Louvre Museum, Paris', '2024-08-07 10:00:00', 'Guided tour of the world-famous Louvre Museum, home to the Mona Lisa.', 4, '2025-05-06 09:28:56', '2025-05-06 09:28:56'),
(12, 'Seine River Cruise', 'Seine River, Paris', '2024-08-08 10:00:00', 'Romantic evening cruise along the Seine River with dinner.', 4, '2025-05-06 09:28:56', '2025-05-06 09:28:56'),
(13, 'Medina Exploration', 'Medina, Marrakech', '2024-09-13 10:00:00', 'Guided walk through the ancient Medina and its bustling souks.', 5, '2025-05-06 09:28:56', '2025-05-06 09:28:56'),
(14, 'Majorelle Garden Visit', 'Majorelle Garden, Marrakech', '2024-09-14 10:00:00', 'Visit the stunning blue Majorelle Garden and YSL Museum.', 5, '2025-05-06 09:28:56', '2025-05-06 09:28:56'),
(15, 'Desert Camel Ride', 'Agafay Desert, Marrakech', '2024-09-15 10:00:00', 'Sunset camel ride in the desert followed by traditional dinner.', 5, '2025-05-06 09:28:56', '2025-05-06 09:28:56'),
(16, 'Ubud Sacred Monkey Forest', 'Ubud, Bali', '2024-10-02 10:00:00', 'Visit the sacred monkey forest sanctuary with hundreds of monkeys.', 6, '2025-05-06 09:28:56', '2025-05-06 09:28:56'),
(17, 'Rice Terrace Trek', 'Tegallalang, Bali', '2024-10-03 10:00:00', 'Trek through the beautiful rice terraces of Tegallalang.', 6, '2025-05-06 09:28:56', '2025-05-06 09:28:56'),
(18, 'Tanah Lot Temple Sunset', 'Tanah Lot, Bali', '2024-10-04 10:00:00', 'Watch the sunset at the beautiful sea temple of Tanah Lot.', 6, '2025-05-06 09:28:56', '2025-05-06 09:28:56');

CREATE TABLE `bookings` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `room_id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `start_date` date NOT NULL,
  `end_date` date NOT NULL,
  `total_price` decimal(10,2) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `check_in` date DEFAULT NULL,
  `check_out` date DEFAULT NULL,
  `guests` int(11) NOT NULL DEFAULT 1,
  `status` varchar(255) NOT NULL DEFAULT 'pending',
  `special_requests` text DEFAULT NULL
)

CREATE TABLE `categories` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `slug` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL,
  `is_featured` tinyint(1) NOT NULL DEFAULT 0,
  `meta_title` varchar(255) DEFAULT NULL,
  `meta_description` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
)

INSERT INTO `categories` (`id`, `name`, `slug`, `description`, `image`, `is_featured`, `meta_title`, `meta_description`, `created_at`, `updated_at`) VALUES
(1, 'Adventure', 'adventure', 'Exciting adventures for thrill-seekers', 'adventure.jpg', 1, 'Adventure Trips', 'Find the best adventure trips.', '2025-05-06 09:28:56', '2025-05-06 09:28:56'),
(2, 'Cultural', 'cultural', 'Explore local customs and traditions', 'cultural.jpg', 1, 'Cultural Trips', 'Find the best cultural trips.', '2025-05-06 09:28:56', '2025-05-06 09:28:56'),
(3, 'Beach', 'beach', 'Relax on beautiful beaches', 'beach.jpg', 1, 'Beach Trips', 'Find the best beach trips.', '2025-05-06 09:28:56', '2025-05-06 09:28:56'),
(4, 'Mountain', 'mountain', 'Explore majestic mountains and peaks', 'mountain.jpg', 0, 'Mountain Trips', 'Find the best mountain trips.', '2025-05-06 09:28:56', '2025-05-06 09:28:56'),
(5, 'City Break', 'city-break', 'Short trips to explore vibrant cities', 'city.jpg', 0, 'City Break Trips', 'Find the best city break trips.', '2025-05-06 09:28:56', '2025-05-06 09:28:56'),
(6, 'Wildlife', 'wildlife', 'Experience nature and wildlife up close', 'wildlife.jpg', 0, 'Wildlife Trips', 'Find the best wildlife trips.', '2025-05-06 09:28:56', '2025-05-06 09:28:56');

CREATE TABLE `destinations` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `slug` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL,
  `location` varchar(255) DEFAULT NULL,
  `is_featured` tinyint(1) NOT NULL DEFAULT 0,
  `meta_title` varchar(255) DEFAULT NULL,
  `meta_description` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
)

INSERT INTO `destinations` (`id`, `name`, `slug`, `description`, `image`, `location`, `is_featured`, `meta_title`, `meta_description`, `created_at`, `updated_at`) VALUES
(1, 'Paris', 'paris', 'The City of Light famous for its art, culture, and cuisine.', 'paris.jpg', 'France', 1, 'Visit Paris', 'Plan your trip to Paris, France', '2025-05-06 09:28:57', '2025-05-06 09:28:57'),
(2, 'Marrakech', 'marrakech', 'A vibrant city with bustling markets and rich cultural heritage.', 'marrakech.jpg', 'Morocco', 1, 'Visit Marrakech', 'Plan your trip to Marrakech, Morocco', '2025-05-06 09:28:57', '2025-05-06 09:28:57'),
(3, 'Bali', 'bali', 'Tropical paradise with beautiful beaches and spiritual retreats.', 'bali.jpg', 'Indonesia', 1, 'Visit Bali', 'Plan your trip to Bali, Indonesia', '2025-05-06 09:28:57', '2025-05-06 09:28:57'),
(4, 'Tokyo', 'tokyo', 'Ultra-modern city with a blend of traditional culture.', 'tokyo.jpg', 'Japan', 0, 'Visit Tokyo', 'Plan your trip to Tokyo, Japan', '2025-05-06 09:28:57', '2025-05-06 09:28:57'),
(5, 'New York', 'new-york', 'The city that never sleeps with iconic landmarks and diverse culture.', 'newyork.jpg', 'USA', 0, 'Visit New York', 'Plan your trip to New York, USA', '2025-05-06 09:28:57', '2025-05-06 09:28:57'),
(6, 'Cape Town', 'cape-town', 'Stunning coastal city with beautiful mountains and beaches.', 'capetown.jpg', 'South Africa', 0, 'Visit Cape Town', 'Plan your trip to Cape Town, South Africa', '2025-05-06 09:28:57', '2025-05-06 09:28:57'),
(7, 'Rio de Janeiro', 'rio-de-janeiro', 'Vibrant city known for its beaches, mountains, and carnival.', 'rio.jpg', 'Brazil', 0, 'Visit Rio de Janeiro', 'Plan your trip to Rio de Janeiro, Brazil', '2025-05-06 09:28:57', '2025-05-06 09:28:57'),
(8, 'Sydney', 'sydney', 'Iconic harbor city with beautiful beaches and landmarks.', 'sydney.jpg', 'Australia', 0, 'Visit Sydney', 'Plan your trip to Sydney, Australia', '2025-05-06 09:28:57', '2025-05-06 09:28:57');

CREATE TABLE `failed_jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `uuid` varchar(255) NOT NULL,
  `connection` text NOT NULL,
  `queue` text NOT NULL,
  `payload` longtext NOT NULL,
  `exception` longtext NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT current_timestamp()
)

CREATE TABLE `guides` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `license_number` varchar(255) DEFAULT NULL,
  `specialization` varchar(255) DEFAULT NULL,
  `preferred_locations` text DEFAULT NULL,
  `selected_dates` text DEFAULT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `availability` enum('available','not available') NOT NULL DEFAULT 'not available',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
)

INSERT INTO `guides` (`id`, `license_number`, `specialization`, `preferred_locations`, `selected_dates`, `user_id`, `availability`, `created_at`, `updated_at`) VALUES
(1, 'G12345', 'Desert Tours', 'Marrakech, Fes, Sahara', NULL, 4, 'not available', '2025-05-06 09:28:56', '2025-05-06 09:28:56'),
(2, 'G-12345', 'Cultural Tours', NULL, NULL, 4, 'not available', '2025-05-06 09:28:56', '2025-05-06 09:28:56'),
(3, 'G-23456', 'Adventure Tours', NULL, NULL, 4, 'not available', '2025-05-06 09:28:56', '2025-05-06 09:28:56'),
(4, 'G-34567', 'Historical Tours', NULL, NULL, 4, 'not available', '2025-05-06 09:28:56', '2025-05-06 09:28:56');

CREATE TABLE `hotels` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `price_per_night` decimal(8,2) NOT NULL DEFAULT 0.00,
  `longitude` decimal(10,7) DEFAULT NULL,
  `latitude` decimal(10,7) DEFAULT NULL,
  `available_rooms` int(11) NOT NULL DEFAULT 0,
  `star_rating` int(11) NOT NULL DEFAULT 0,
  `availability` enum('available','not available') NOT NULL DEFAULT 'not available',
  `selected_dates` text DEFAULT NULL,
  `description` text DEFAULT NULL,
  `amenities` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`amenities`)),
  `image` varchar(255) DEFAULT NULL,
  `address` varchar(255) NOT NULL,
  `country` varchar(255) NOT NULL,
  `city` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
)

INSERT INTO `hotels` (`id`, `user_id`, `price_per_night`, `longitude`, `latitude`, `available_rooms`, `star_rating`, `availability`, `selected_dates`, `description`, `amenities`, `image`, `address`, `country`, `city`, `name`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 5, 200.00, -9.5981000, 30.4278000, 0, 5, 'not available', NULL, 'Luxury hotel with stunning views', '\"[\\\"wifi\\\",\\\"pool\\\",\\\"spa\\\",\\\"restaurant\\\"]\"', 'hotels/royal-mirage.jpg', '123 Beach Avenue', 'Morocco', 'Agadir', 'Royal Mirage Resort', '2025-05-06 09:28:56', '2025-05-06 09:28:56', NULL),
(2, 5, 350.00, 2.3522000, 48.8566000, 0, 5, 'not available', NULL, 'A luxurious 5-star hotel with stunning views.', '\"[\\\"Swimming Pool\\\",\\\"Spa\\\",\\\"Gym\\\",\\\"Restaurant\\\",\\\"Room Service\\\"]\"', 'grand-luxury.jpg', '123 Main Street', 'France', 'Paris', 'Grand Luxury Hotel', '2025-05-06 09:28:56', '2025-05-06 09:28:56', NULL),
(3, 5, 220.00, 115.1889000, -8.4095000, 0, 4, 'not available', NULL, 'Beachfront hotel with private access to the beach.', '\"[\\\"Beach Access\\\",\\\"Swimming Pool\\\",\\\"Restaurant\\\",\\\"Bar\\\",\\\"Wifi\\\"]\"', 'coastal-retreat.jpg', '456 Ocean Drive', 'Indonesia', 'Bali', 'Coastal Retreat', '2025-05-06 09:28:56', '2025-05-06 09:28:56', NULL),
(4, 5, 280.00, 139.6503000, 35.6762000, 0, 4, 'not available', NULL, 'Modern hotel in the heart of the city.', '\"[\\\"Gym\\\",\\\"Restaurant\\\",\\\"Business Center\\\",\\\"Wifi\\\",\\\"Concierge\\\"]\"', 'urban-oasis.jpg', '789 City Center', 'Japan', 'Tokyo', 'Urban Oasis Hotel', '2025-05-06 09:28:56', '2025-05-06 09:28:56', NULL);

CREATE TABLE `itineraries` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `title` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `trip_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
)

INSERT INTO `itineraries` (`id`, `title`, `description`, `trip_id`, `created_at`, `updated_at`) VALUES
(1, 'Morocco Adventure', 'Explore the beautiful landscapes of Morocco', 1, '2025-05-06 09:28:56', '2025-05-06 09:28:56'),
(2, 'Romantic Parisian Adventure', 'Explore the most romantic spots in Paris, including the Eiffel Tower, Seine River cruise, and Montmartre.', 2, '2025-05-06 09:28:57', '2025-05-06 09:28:57'),
(3, 'Moroccan Cultural Immersion', 'Dive into Moroccan culture with visits to the markets, palaces, and desert excursions.', 3, '2025-05-06 09:28:57', '2025-05-06 09:28:57'),
(4, 'Bali Paradise Retreat', 'Relax and rejuvenate on the beautiful beaches of Bali, with visits to temples and rice terraces.', 4, '2025-05-06 09:28:57', '2025-05-06 09:28:57'),
(5, 'Tokyo Urban Explorer', 'Experience the perfect blend of traditional and modern Japan in Tokyo.', 5, '2025-05-06 09:28:57', '2025-05-06 09:28:57'),
(6, 'New York City Discovery', 'Experience the best of NYC with visits to iconic landmarks, museums, and neighborhoods.', 6, '2025-05-06 09:28:57', '2025-05-06 09:28:57');

CREATE TABLE `messages` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `sender_id` bigint(20) UNSIGNED NOT NULL,
  `receiver_id` bigint(20) UNSIGNED NOT NULL,
  `message` text NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
)

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) NOT NULL,
  `batch` int(11) NOT NULL
)

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '2014_10_12_000000_create_users_table', 1),
(2, '2014_10_12_100000_create_password_resets_table', 1),
(3, '2019_08_19_000000_create_failed_jobs_table', 1),
(4, '2019_12_14_000001_create_personal_access_tokens_table', 1),
(5, '2023_05_15_000000_create_hotels_table', 1),
(6, '2023_05_15_000001_create_room_types_table', 1),
(7, '2023_05_15_000002_create_rooms_table', 1),
(8, '2023_05_15_000003_create_bookings_table', 1),
(9, '2023_10_30_000001_create_categories_table', 1),
(10, '2023_10_30_000002_create_tags_table', 1),
(11, '2023_10_30_000004_create_destinations_table', 1),
(12, '2024_05_05_create_bookings_table', 1),
(13, '2025_03_17_233142_create_transports_table', 1),
(14, '2025_03_17_235921_create_guides_table', 1),
(15, '2025_03_18_134302_create_trips_table', 1),
(16, '2025_03_18_141024_create_itineraries_table', 1),
(17, '2025_03_20_105231_create_activities_table', 1),
(18, '2025_04_09_092946_create_travellers_table', 1),
(19, '2025_04_09_115837_create_permission_tables', 1),
(20, '2025_04_10_000001_create_trip_relationships_tables', 1),
(21, '2025_04_17_135630_create_messages_table', 1),
(22, '2025_04_18_120000_create_reviews_table', 1);

CREATE TABLE `model_has_permissions` (
  `permission_id` bigint(20) UNSIGNED NOT NULL,
  `model_type` varchar(255) NOT NULL,
  `model_id` bigint(20) UNSIGNED NOT NULL
)

CREATE TABLE `model_has_roles` (
  `role_id` bigint(20) UNSIGNED NOT NULL,
  `model_type` varchar(255) NOT NULL,
  `model_id` bigint(20) UNSIGNED NOT NULL
)

CREATE TABLE `password_resets` (
  `email` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
)

CREATE TABLE `permissions` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `guard_name` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
)

CREATE TABLE `personal_access_tokens` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `tokenable_type` varchar(255) NOT NULL,
  `tokenable_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `token` varchar(64) NOT NULL,
  `abilities` text DEFAULT NULL,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `expires_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
)

CREATE TABLE `reviews` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `traveller_id` bigint(20) UNSIGNED NOT NULL,
  `hotel_id` bigint(20) UNSIGNED NOT NULL,
  `guide_id` bigint(20) UNSIGNED NOT NULL,
  `rating` tinyint(3) UNSIGNED NOT NULL,
  `comment` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
)

CREATE TABLE `roles` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `guard_name` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
)

CREATE TABLE `role_has_permissions` (
  `permission_id` bigint(20) UNSIGNED NOT NULL,
  `role_id` bigint(20) UNSIGNED NOT NULL
)

CREATE TABLE `rooms` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `hotel_id` bigint(20) UNSIGNED NOT NULL,
  `room_type_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `room_number` varchar(255) DEFAULT NULL,
  `capacity` int(11) NOT NULL,
  `price_per_night` decimal(8,2) NOT NULL,
  `is_available` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
)

CREATE TABLE `room_types` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
)

INSERT INTO `room_types` (`id`, `name`, `description`, `created_at`, `updated_at`) VALUES
(1, 'Standard', 'A comfortable room with all basic amenities', '2025-05-06 09:28:56', '2025-05-06 09:28:56'),
(2, 'Deluxe', 'A spacious room with premium amenities and services', '2025-05-06 09:28:56', '2025-05-06 09:28:56'),
(3, 'Suite', 'A luxury accommodation with separate living area and bedroom', '2025-05-06 09:28:56', '2025-05-06 09:28:56'),
(4, 'Family', 'A large room suitable for families with children', '2025-05-06 09:28:56', '2025-05-06 09:28:56'),
(5, 'Single', 'A cozy room designed for one person', '2025-05-06 09:28:56', '2025-05-06 09:28:56'),
(6, 'Twin', 'A room with two single beds', '2025-05-06 09:28:56', '2025-05-06 09:28:56');

CREATE TABLE `tags` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `slug` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `meta_title` varchar(255) DEFAULT NULL,
  `meta_description` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
)

INSERT INTO `tags` (`id`, `name`, `slug`, `description`, `meta_title`, `meta_description`, `created_at`, `updated_at`) VALUES
(1, 'Family Friendly', 'family-friendly', 'Trips related to family friendly', 'Family Friendly Trips', 'Find the best trips for family friendly', '2025-05-06 09:28:55', '2025-05-06 09:28:55'),
(2, 'Food & Cuisine', 'food-cuisine', 'Trips related to food & cuisine', 'Food & Cuisine Trips', 'Find the best trips for food & cuisine', '2025-05-06 09:28:55', '2025-05-06 09:28:55'),
(3, 'Solo Traveler', 'solo-traveler', 'Trips related to solo traveler', 'Solo Traveler Trips', 'Find the best trips for solo traveler', '2025-05-06 09:28:55', '2025-05-06 09:28:55'),
(4, 'Art & Museums', 'art-museums', 'Trips related to art & museums', 'Art & Museums Trips', 'Find the best trips for art & museums', '2025-05-06 09:28:55', '2025-05-06 09:28:55'),
(5, 'Eco-Friendly', 'eco-friendly', 'Trips related to eco-friendly', 'Eco-Friendly Trips', 'Find the best trips for eco-friendly', '2025-05-06 09:28:55', '2025-05-06 09:28:55'),
(6, 'Photography', 'photography', 'Trips related to photography', 'Photography Trips', 'Find the best trips for photography', '2025-05-06 09:28:55', '2025-05-06 09:28:55'),
(7, 'Snorkeling', 'snorkeling', 'Trips related to snorkeling', 'Snorkeling Trips', 'Find the best trips for snorkeling', '2025-05-06 09:28:55', '2025-05-06 09:28:55'),
(8, 'Relaxation', 'relaxation', 'Trips related to relaxation', 'Relaxation Trips', 'Find the best trips for relaxation', '2025-05-06 09:28:55', '2025-05-06 09:28:55'),
(9, 'Road Trip', 'road-trip', 'Trips related to road trip', 'Road Trip Trips', 'Find the best trips for road trip', '2025-05-06 09:28:55', '2025-05-06 09:28:55'),
(10, 'Nightlife', 'nightlife', 'Trips related to nightlife', 'Nightlife Trips', 'Find the best trips for nightlife', '2025-05-06 09:28:55', '2025-05-06 09:28:55'),
(11, 'Wellness', 'wellness', 'Trips related to wellness', 'Wellness Trips', 'Find the best trips for wellness', '2025-05-06 09:28:55', '2025-05-06 09:28:55'),
(12, 'Shopping', 'shopping', 'Trips related to shopping', 'Shopping Trips', 'Find the best trips for shopping', '2025-05-06 09:28:55', '2025-05-06 09:28:55'),
(13, 'Swimming', 'swimming', 'Trips related to swimming', 'Swimming Trips', 'Find the best trips for swimming', '2025-05-06 09:28:55', '2025-05-06 09:28:55'),
(14, 'Couples', 'couples', 'Trips related to couples', 'Couples Trips', 'Find the best trips for couples', '2025-05-06 09:28:55', '2025-05-06 09:28:55'),
(15, 'Surfing', 'surfing', 'Trips related to surfing', 'Surfing Trips', 'Find the best trips for surfing', '2025-05-06 09:28:55', '2025-05-06 09:28:55'),
(16, 'History', 'history', 'Trips related to history', 'History Trips', 'Find the best trips for history', '2025-05-06 09:28:55', '2025-05-06 09:28:55'),
(17, 'Luxury', 'luxury', 'Trips related to luxury', 'Luxury Trips', 'Find the best trips for luxury', '2025-05-06 09:28:55', '2025-05-06 09:28:55'),
(18, 'Budget', 'budget', 'Trips related to budget', 'Budget Trips', 'Find the best trips for budget', '2025-05-06 09:28:55', '2025-05-06 09:28:55'),
(19, 'Hiking', 'hiking', 'Trips related to hiking', 'Hiking Trips', 'Find the best trips for hiking', '2025-05-06 09:28:55', '2025-05-06 09:28:55'),
(20, 'Skiing', 'skiing', 'Trips related to skiing', 'Skiing Trips', 'Find the best trips for skiing', '2025-05-06 09:28:55', '2025-05-06 09:28:55');

CREATE TABLE `transports` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `company_name` varchar(255) NOT NULL,
  `transport_type` enum('Tourist vehicle','Plane','Train','Horse','Camel','Bus') NOT NULL DEFAULT 'Tourist vehicle',
  `license_number` varchar(255) NOT NULL,
  `address` varchar(255) NOT NULL,
  `phone` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
)

INSERT INTO `transports` (`id`, `user_id`, `company_name`, `transport_type`, `license_number`, `address`, `phone`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 6, 'Morocco Express', 'Tourist vehicle', 'T54321', '456 Main Street, Casablanca', '+212 555-1234', '2025-05-06 09:28:56', '2025-05-06 09:28:56', NULL);

CREATE TABLE `travellers` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `trip_id` bigint(20) UNSIGNED DEFAULT NULL,
  `itinerary_id` bigint(20) UNSIGNED DEFAULT NULL,
  `passport_number` varchar(255) DEFAULT NULL,
  `prefered_destination` varchar(255) DEFAULT NULL,
  `nationality` varchar(255) DEFAULT NULL,
  `payment_status` enum('pending','paid','cancelled','refunded') DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
)

INSERT INTO `travellers` (`id`, `user_id`, `trip_id`, `itinerary_id`, `passport_number`, `prefered_destination`, `nationality`, `payment_status`, `created_at`, `updated_at`) VALUES
(1, 3, 1, 1, NULL, 'Morocco', 'United States', NULL, '2025-05-06 09:28:56', '2025-05-06 09:28:56'),
(2, 3, 1, 1, 'P005980', 'Paris', 'American', NULL, '2025-05-06 09:28:57', '2025-05-06 09:28:57');

CREATE TABLE `trips` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `destination` varchar(255) NOT NULL,
  `start_date` date NOT NULL,
  `end_date` date NOT NULL,
  `cover_picture` varchar(255) DEFAULT NULL,
  `manager_id` bigint(20) UNSIGNED DEFAULT NULL,
  `status` enum('active','suspended') NOT NULL DEFAULT 'active',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
)

INSERT INTO `trips` (`id`, `destination`, `start_date`, `end_date`, `cover_picture`, `manager_id`, `status`, `created_at`, `updated_at`) VALUES
(1, 'Morocco Explorer', '2025-06-06', '2025-06-16', NULL, NULL, 'active', '2025-05-06 09:28:56', '2025-05-06 09:28:56'),
(2, 'Paris, France', '2024-06-15', '2024-06-22', 'paris-trip.jpg', NULL, 'active', '2025-05-06 09:28:56', '2025-05-06 09:28:56'),
(3, 'Marrakech, Morocco', '2024-07-10', '2024-07-20', 'marrakech-trip.jpg', NULL, 'active', '2025-05-06 09:28:56', '2025-05-06 09:28:56'),
(4, 'Bali, Indonesia', '2024-08-05', '2024-08-15', 'bali-trip.jpg', NULL, 'active', '2025-05-06 09:28:56', '2025-05-06 09:28:56'),
(5, 'Tokyo, Japan', '2024-09-12', '2024-09-22', 'tokyo-trip.jpg', NULL, 'active', '2025-05-06 09:28:56', '2025-05-06 09:28:56'),
(6, 'New York, USA', '2024-10-01', '2024-10-08', 'newyork-trip.jpg', NULL, 'active', '2025-05-06 09:28:56', '2025-05-06 09:28:56');

CREATE TABLE `trip_category` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `trip_id` bigint(20) UNSIGNED NOT NULL,
  `category_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
)

INSERT INTO `trip_category` (`id`, `trip_id`, `category_id`, `created_at`, `updated_at`) VALUES
(1, 1, 2, NULL, NULL),
(2, 1, 6, NULL, NULL),
(3, 2, 3, NULL, NULL),
(4, 2, 4, NULL, NULL),
(5, 3, 3, NULL, NULL),
(6, 4, 4, NULL, NULL),
(7, 5, 1, NULL, NULL),
(8, 5, 4, NULL, NULL),
(9, 6, 1, NULL, NULL);

CREATE TABLE `trip_guide` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `trip_id` bigint(20) UNSIGNED NOT NULL,
  `guide_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
)

INSERT INTO `trip_guide` (`id`, `trip_id`, `guide_id`, `created_at`, `updated_at`) VALUES
(1, 1, 3, NULL, NULL),
(2, 2, 4, NULL, NULL),
(3, 3, 4, NULL, NULL),
(4, 4, 4, NULL, NULL),
(5, 5, 1, NULL, NULL),
(6, 6, 2, NULL, NULL);

CREATE TABLE `trip_hotel` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `trip_id` bigint(20) UNSIGNED NOT NULL,
  `hotel_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
)

INSERT INTO `trip_hotel` (`id`, `trip_id`, `hotel_id`, `created_at`, `updated_at`) VALUES
(1, 1, 4, NULL, NULL),
(2, 2, 4, NULL, NULL),
(3, 3, 3, NULL, NULL),
(4, 4, 1, NULL, NULL),
(5, 5, 1, NULL, NULL),
(6, 6, 1, NULL, NULL);

CREATE TABLE `trip_tag` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `trip_id` bigint(20) UNSIGNED NOT NULL,
  `tag_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
)

INSERT INTO `trip_tag` (`id`, `trip_id`, `tag_id`, `created_at`, `updated_at`) VALUES
(1, 1, 6, NULL, NULL),
(2, 1, 8, NULL, NULL),
(3, 1, 14, NULL, NULL),
(4, 1, 18, NULL, NULL),
(5, 2, 7, NULL, NULL),
(6, 2, 10, NULL, NULL),
(7, 2, 16, NULL, NULL),
(8, 2, 17, NULL, NULL),
(9, 2, 20, NULL, NULL),
(10, 3, 4, NULL, NULL),
(11, 3, 8, NULL, NULL),
(12, 3, 11, NULL, NULL),
(13, 4, 2, NULL, NULL),
(14, 4, 15, NULL, NULL),
(15, 4, 19, NULL, NULL),
(16, 5, 3, NULL, NULL),
(17, 5, 7, NULL, NULL),
(18, 5, 8, NULL, NULL),
(19, 5, 16, NULL, NULL),
(20, 5, 18, NULL, NULL),
(21, 6, 1, NULL, NULL),
(22, 6, 4, NULL, NULL),
(23, 6, 13, NULL, NULL),
(24, 6, 16, NULL, NULL),
(25, 6, 20, NULL, NULL);

CREATE TABLE `trip_transport` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `trip_id` bigint(20) UNSIGNED NOT NULL,
  `transport_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
)

INSERT INTO `trip_transport` (`id`, `trip_id`, `transport_id`, `created_at`, `updated_at`) VALUES
(1, 1, 1, NULL, NULL),
(2, 2, 1, NULL, NULL),
(3, 3, 1, NULL, NULL),
(4, 4, 1, NULL, NULL),
(5, 5, 1, NULL, NULL),
(6, 6, 1, NULL, NULL);

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `picture` varchar(255) DEFAULT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `status` enum('valide','suspend','block') NOT NULL DEFAULT 'suspend',
  `role` enum('transport','traveller','admin','hotel','guide','manager') NOT NULL DEFAULT 'traveller',
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
)

INSERT INTO `users` (`id`, `name`, `password`, `email`, `picture`, `email_verified_at`, `status`, `role`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 'Admin User', '$2y$10$6LI31tTDpr8EfnLBMGLSK.WH5.7UFgNkq9qhYoietMbnMwXh1tOGS', 'admin@admin.com', NULL, NULL, 'valide', 'admin', NULL, '2025-05-06 09:28:56', '2025-05-06 09:28:56'),
(2, 'Trip Manager', '$2y$10$Y/rIC3/4xDGf7gMjYMLASu.NNGwP8FVkMY//u0EOQmLUlLkVJbqsy', 'manager@manager.com', NULL, NULL, 'valide', 'manager', NULL, '2025-05-06 09:28:56', '2025-05-06 09:28:56'),
(3, 'Traveller User', '$2y$10$rKQffH.g.n9/EHWE3oo7k.K/rEE9gDwNjU2on7jdvi1DzkqMVl9ji', 'traveller@traveller.com', NULL, NULL, 'valide', 'traveller', NULL, '2025-05-06 09:28:56', '2025-05-06 09:28:56'),
(4, 'Guide User', '$2y$10$iPnaGYpaesd7jUMG8M9RlOZ.jRjKHvNkLHPlyIVrVj.dNxMD6NBPu', 'guide@guide.com', NULL, NULL, 'valide', 'guide', NULL, '2025-05-06 09:28:56', '2025-05-06 09:28:56'),
(5, 'Hotel User', '$2y$10$mX4Ss3dSXPcLjhlN6qTJOea7ql0do5BuGEpAgx0Hcyqi3G5o7Iaui', 'hotel@hotel.com', NULL, NULL, 'valide', 'hotel', NULL, '2025-05-06 09:28:56', '2025-05-06 09:28:56'),
(6, 'Transport User', '$2y$10$TldcvreCYod3tgqBAit3a.nb6mR0/dCWrefSDpb81PcW4MZhZEa02', 'transport@transport.com', NULL, NULL, 'valide', 'transport', NULL, '2025-05-06 09:28:56', '2025-05-06 09:28:56');

ALTER TABLE `activities`
  ADD PRIMARY KEY (`id`),
  ADD KEY `activities_trip_id_foreign` (`trip_id`);

ALTER TABLE `bookings`
  ADD PRIMARY KEY (`id`),
  ADD KEY `bookings_room_id_foreign` (`room_id`),
  ADD KEY `bookings_user_id_foreign` (`user_id`);

ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `categories_slug_unique` (`slug`);

ALTER TABLE `destinations`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `destinations_slug_unique` (`slug`);

ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

ALTER TABLE `guides`
  ADD PRIMARY KEY (`id`),
  ADD KEY `guides_user_id_foreign` (`user_id`);

ALTER TABLE `hotels`
  ADD PRIMARY KEY (`id`),
  ADD KEY `hotels_user_id_foreign` (`user_id`);

ALTER TABLE `itineraries`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `itineraries_trip_id_unique` (`trip_id`);

ALTER TABLE `messages`
  ADD PRIMARY KEY (`id`),
  ADD KEY `messages_sender_id_foreign` (`sender_id`),
  ADD KEY `messages_receiver_id_foreign` (`receiver_id`);

ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `model_has_permissions`
  ADD PRIMARY KEY (`permission_id`,`model_id`,`model_type`),
  ADD KEY `model_has_permissions_model_id_model_type_index` (`model_id`,`model_type`);

ALTER TABLE `model_has_roles`
  ADD PRIMARY KEY (`role_id`,`model_id`,`model_type`),
  ADD KEY `model_has_roles_model_id_model_type_index` (`model_id`,`model_type`);

ALTER TABLE `password_resets`
  ADD PRIMARY KEY (`email`);

ALTER TABLE `permissions`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `permissions_name_guard_name_unique` (`name`,`guard_name`);

ALTER TABLE `personal_access_tokens`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  ADD KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`);

ALTER TABLE `reviews`
  ADD PRIMARY KEY (`id`),
  ADD KEY `reviews_traveller_id_foreign` (`traveller_id`),
  ADD KEY `reviews_hotel_id_foreign` (`hotel_id`),
  ADD KEY `reviews_guide_id_foreign` (`guide_id`);

ALTER TABLE `roles`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `roles_name_guard_name_unique` (`name`,`guard_name`);

ALTER TABLE `role_has_permissions`
  ADD PRIMARY KEY (`permission_id`,`role_id`),
  ADD KEY `role_has_permissions_role_id_foreign` (`role_id`);

ALTER TABLE `rooms`
  ADD PRIMARY KEY (`id`),
  ADD KEY `rooms_hotel_id_foreign` (`hotel_id`),
  ADD KEY `rooms_room_type_id_foreign` (`room_type_id`);

ALTER TABLE `room_types`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `tags`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `tags_slug_unique` (`slug`);

ALTER TABLE `transports`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `transports_license_number_unique` (`license_number`),
  ADD KEY `transports_user_id_index` (`user_id`);

ALTER TABLE `travellers`
  ADD PRIMARY KEY (`id`),
  ADD KEY `travellers_user_id_foreign` (`user_id`),
  ADD KEY `travellers_trip_id_foreign` (`trip_id`),
  ADD KEY `travellers_itinerary_id_foreign` (`itinerary_id`);

ALTER TABLE `trips`
  ADD PRIMARY KEY (`id`),
  ADD KEY `trips_manager_id_foreign` (`manager_id`);

ALTER TABLE `trip_category`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `trip_category_trip_id_category_id_unique` (`trip_id`,`category_id`),
  ADD KEY `trip_category_category_id_foreign` (`category_id`);

ALTER TABLE `trip_guide`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `trip_guide_trip_id_guide_id_unique` (`trip_id`,`guide_id`),
  ADD KEY `trip_guide_guide_id_foreign` (`guide_id`);

ALTER TABLE `trip_hotel`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `trip_hotel_trip_id_hotel_id_unique` (`trip_id`,`hotel_id`),
  ADD KEY `trip_hotel_hotel_id_foreign` (`hotel_id`);

ALTER TABLE `trip_tag`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `trip_tag_trip_id_tag_id_unique` (`trip_id`,`tag_id`),
  ADD KEY `trip_tag_tag_id_foreign` (`tag_id`);

ALTER TABLE `trip_transport`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `trip_transport_trip_id_transport_id_unique` (`trip_id`,`transport_id`),
  ADD KEY `trip_transport_transport_id_foreign` (`transport_id`);

ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

ALTER TABLE `activities`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

ALTER TABLE `bookings`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

ALTER TABLE `categories`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

ALTER TABLE `destinations`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

ALTER TABLE `guides`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

ALTER TABLE `hotels`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

ALTER TABLE `itineraries`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

ALTER TABLE `messages`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

ALTER TABLE `permissions`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

ALTER TABLE `personal_access_tokens`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

ALTER TABLE `reviews`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

ALTER TABLE `roles`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

ALTER TABLE `rooms`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

ALTER TABLE `room_types`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

ALTER TABLE `tags`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

ALTER TABLE `transports`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

ALTER TABLE `travellers`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

ALTER TABLE `trips`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

ALTER TABLE `trip_category`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

ALTER TABLE `trip_guide`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

ALTER TABLE `trip_hotel`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

ALTER TABLE `trip_tag`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

ALTER TABLE `trip_transport`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

ALTER TABLE `activities`
  ADD CONSTRAINT `activities_trip_id_foreign` FOREIGN KEY (`trip_id`) REFERENCES `trips` (`id`) ON DELETE CASCADE;

ALTER TABLE `bookings`
  ADD CONSTRAINT `bookings_room_id_foreign` FOREIGN KEY (`room_id`) REFERENCES `rooms` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `bookings_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

ALTER TABLE `guides`
  ADD CONSTRAINT `guides_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

ALTER TABLE `hotels`
  ADD CONSTRAINT `hotels_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

ALTER TABLE `itineraries`
  ADD CONSTRAINT `itineraries_trip_id_foreign` FOREIGN KEY (`trip_id`) REFERENCES `trips` (`id`) ON DELETE CASCADE;

ALTER TABLE `messages`
  ADD CONSTRAINT `messages_receiver_id_foreign` FOREIGN KEY (`receiver_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `messages_sender_id_foreign` FOREIGN KEY (`sender_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

ALTER TABLE `model_has_permissions`
  ADD CONSTRAINT `model_has_permissions_permission_id_foreign` FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`id`) ON DELETE CASCADE;

ALTER TABLE `model_has_roles`
  ADD CONSTRAINT `model_has_roles_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE;

ALTER TABLE `reviews`
  ADD CONSTRAINT `reviews_guide_id_foreign` FOREIGN KEY (`guide_id`) REFERENCES `guides` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `reviews_hotel_id_foreign` FOREIGN KEY (`hotel_id`) REFERENCES `hotels` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `reviews_traveller_id_foreign` FOREIGN KEY (`traveller_id`) REFERENCES `travellers` (`id`) ON DELETE CASCADE;

ALTER TABLE `role_has_permissions`
  ADD CONSTRAINT `role_has_permissions_permission_id_foreign` FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `role_has_permissions_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE;

ALTER TABLE `rooms`
  ADD CONSTRAINT `rooms_hotel_id_foreign` FOREIGN KEY (`hotel_id`) REFERENCES `hotels` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `rooms_room_type_id_foreign` FOREIGN KEY (`room_type_id`) REFERENCES `room_types` (`id`) ON DELETE CASCADE;

ALTER TABLE `transports`
  ADD CONSTRAINT `transports_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

ALTER TABLE `travellers`
  ADD CONSTRAINT `travellers_itinerary_id_foreign` FOREIGN KEY (`itinerary_id`) REFERENCES `itineraries` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `travellers_trip_id_foreign` FOREIGN KEY (`trip_id`) REFERENCES `trips` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `travellers_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

ALTER TABLE `trips`
  ADD CONSTRAINT `trips_manager_id_foreign` FOREIGN KEY (`manager_id`) REFERENCES `users` (`id`) ON DELETE SET NULL;

ALTER TABLE `trip_category`
  ADD CONSTRAINT `trip_category_category_id_foreign` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `trip_category_trip_id_foreign` FOREIGN KEY (`trip_id`) REFERENCES `trips` (`id`) ON DELETE CASCADE;

ALTER TABLE `trip_guide`
  ADD CONSTRAINT `trip_guide_guide_id_foreign` FOREIGN KEY (`guide_id`) REFERENCES `guides` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `trip_guide_trip_id_foreign` FOREIGN KEY (`trip_id`) REFERENCES `trips` (`id`) ON DELETE CASCADE;

ALTER TABLE `trip_hotel`
  ADD CONSTRAINT `trip_hotel_hotel_id_foreign` FOREIGN KEY (`hotel_id`) REFERENCES `hotels` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `trip_hotel_trip_id_foreign` FOREIGN KEY (`trip_id`) REFERENCES `trips` (`id`) ON DELETE CASCADE;

ALTER TABLE `trip_tag`
  ADD CONSTRAINT `trip_tag_tag_id_foreign` FOREIGN KEY (`tag_id`) REFERENCES `tags` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `trip_tag_trip_id_foreign` FOREIGN KEY (`trip_id`) REFERENCES `trips` (`id`) ON DELETE CASCADE;

ALTER TABLE `trip_transport`
  ADD CONSTRAINT `trip_transport_transport_id_foreign` FOREIGN KEY (`transport_id`) REFERENCES `transports` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `trip_transport_trip_id_foreign` FOREIGN KEY (`trip_id`) REFERENCES `trips` (`id`) ON DELETE CASCADE;
COMMIT;
