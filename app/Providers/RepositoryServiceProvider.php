<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Repositories\Eloquent\TagRepository;
use App\Repositories\Eloquent\TripRepository;
use App\Repositories\Eloquent\UserRepository;
use App\Repositories\Eloquent\RoomRepository;
use App\Repositories\Eloquent\HotelRepository;
use App\Repositories\Eloquent\GuideRepository;
use App\Repositories\Eloquent\ReviewRepository;
use App\Repositories\Eloquent\BookingRepository;
use App\Repositories\Eloquent\CategoryRepository;
use App\Repositories\Eloquent\RoomTypeRepository;
use App\Repositories\Eloquent\ActivityRepository;
use App\Repositories\Eloquent\ItineraryRepository;
use App\Repositories\Eloquent\TransportRepository;
use App\Repositories\Eloquent\TravellerRepository;
use App\Repositories\Eloquent\DestinationRepository;
use App\Repositories\Interfaces\TagRepositoryInterface;
use App\Repositories\Interfaces\TripRepositoryInterface;
use App\Repositories\Interfaces\UserRepositoryInterface;
use App\Repositories\Interfaces\RoomRepositoryInterface;
use App\Repositories\Interfaces\GuideRepositoryInterface;
use App\Repositories\Interfaces\HotelRepositoryInterface;
use App\Repositories\Interfaces\ReviewRepositoryInterface;
use App\Repositories\Interfaces\BookingRepositoryInterface;
use App\Repositories\Interfaces\RoomTypeRepositoryInterface;
use App\Repositories\Interfaces\CategoryRepositoryInterface;
use App\Repositories\Interfaces\ActivityRepositoryInterface;
use App\Repositories\Interfaces\TransportRepositoryInterface;
use App\Repositories\Interfaces\TravellerRepositoryInterface;
use App\Repositories\Interfaces\ItineraryRepositoryInterface;
use App\Repositories\Interfaces\DestinationRepositoryInterface;

class RepositoryServiceProvider extends ServiceProvider
{
    public function register(){
        $this->app->bind(DestinationRepositoryInterface::class, DestinationRepository::class);
        $this->app->bind(TransportRepositoryInterface::class, TransportRepository::class);
        $this->app->bind(TravellerRepositoryInterface::class, TravellerRepository::class);
        $this->app->bind(ItineraryRepositoryInterface::class, ItineraryRepository::class);
        $this->app->bind(ActivityRepositoryInterface::class, ActivityRepository::class);
        $this->app->bind(CategoryRepositoryInterface::class, CategoryRepository::class);
        $this->app->bind(RoomTypeRepositoryInterface::class, RoomTypeRepository::class);
        $this->app->bind(BookingRepositoryInterface::class, BookingRepository::class);
        $this->app->bind(ReviewRepositoryInterface::class, ReviewRepository::class);
        $this->app->bind(GuideRepositoryInterface::class, GuideRepository::class);
        $this->app->bind(HotelRepositoryInterface::class, HotelRepository::class);
        $this->app->bind(RoomRepositoryInterface::class, RoomRepository::class);
        $this->app->bind(TripRepositoryInterface::class, TripRepository::class);
        $this->app->bind(UserRepositoryInterface::class, UserRepository::class);
        $this->app->bind(TagRepositoryInterface::class, TagRepository::class);
    }
}
