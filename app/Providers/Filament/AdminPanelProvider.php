<?php

namespace App\Providers\Filament;


use Filament\Pages;
use Filament\Panel;
use App\Models\Team;
use Filament\Widgets;
use Filament\PanelProvider;
use App\Filament\Auth\Login;
use Filament\Pages\Dashboard;
use Filament\Facades\Filament;
use App\Filament\Auth\Register;
use Filament\Support\Colors\Color;
use SebastianBergmann\Type\VoidType;
use Filament\Navigation\UserMenuItem;
use Filament\Navigation\NavigationItem;
use App\Filament\Resources\UserResource;
use Filament\Navigation\NavigationGroup;
use Filament\Http\Middleware\Authenticate;
use Filament\Navigation\NavigationBuilder;
use App\Filament\Resources\PeriodeResource;
use App\Filament\Resources\StudentResource;
use App\Filament\Resources\SubjectResource;
use App\Filament\Resources\TeacherResource;
use App\Filament\Pages\Tenancy\RegisterTeam;
use App\Filament\Resources\ClassroomResource;
use App\Filament\Resources\DepartmentResource;
use Illuminate\Session\Middleware\StartSession;
use Illuminate\Cookie\Middleware\EncryptCookies;
use App\Filament\Resources\CategoryNilaiResource;
use App\Filament\Resources\StudentHasClassResource;
use Illuminate\Routing\Middleware\SubstituteBindings;
use Illuminate\Session\Middleware\AuthenticateSession;
use Illuminate\View\Middleware\ShareErrorsFromSession;
use Filament\Http\Middleware\DisableBladeIconComponents;
use Filament\Http\Middleware\DispatchServingFilamentEvent;
use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken;
use Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse;
use Althinect\FilamentSpatieRolesPermissions\FilamentSpatieRolesPermissionsPlugin;

class AdminPanelProvider extends PanelProvider
{
    public function panel(Panel $panel): Panel
    {
        return $panel
            ->default()
            ->sidebarCollapsibleOnDesktop(true)
            ->id('admin')
            ->path('admin')
            ->login(Login::class)
            ->registration(Register::class)
             ->colors([
            'danger' => Color::Rose,
            'gray' => Color::Gray,
            'info' => Color::Blue,
            'primary' => Color::Indigo,
            'success' => Color::Emerald,
            'warning' => Color::Orange,
        ])
            ->discoverResources(in: app_path('Filament/Resources'), for: 'App\\Filament\\Resources')
            ->discoverPages(in: app_path('Filament/Pages'), for: 'App\\Filament\\Pages')
            ->pages([
                Pages\Dashboard::class,
            ])
            ->discoverWidgets(in: app_path('Filament/Widgets'), for: 'App\\Filament\\Widgets')
            ->widgets([
                Widgets\AccountWidget::class,
                
            ])
            ->middleware([
                EncryptCookies::class,
                AddQueuedCookiesToResponse::class,
                StartSession::class,
                AuthenticateSession::class,
                ShareErrorsFromSession::class,
                VerifyCsrfToken::class,
                SubstituteBindings::class,
                DisableBladeIconComponents::class,
                DispatchServingFilamentEvent::class,
            ])
            ->authMiddleware([
                Authenticate::class,
            ])
            ->viteTheme('resources/css/filament/admin/theme.css')
            ->plugin(FilamentSpatieRolesPermissionsPlugin::make())
            // ->tenant(Team::class)
            // ->tenantRegistration(RegisterTeam::class)
            
            ->databaseNotifications();
    }
    
    

    public function boot(): void
    {
        Filament::serving(function (){
            Filament::registerUserMenuItems([
                // UserMenuItem::make()
                //     ->label('Setting')
                //     ->icon('heroicon-o-cog')
                //     ->url(PeriodeResource::getUrl()),
            ]);
        });
    }
}
