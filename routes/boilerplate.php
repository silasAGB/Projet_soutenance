<?php

use App\Http\Controllers\Boilerplate\Auth\ForgotPasswordController;
use App\Http\Controllers\Boilerplate\Auth\LoginController;
use App\Http\Controllers\Boilerplate\Auth\RegisterController;
use App\Http\Controllers\Boilerplate\Auth\ResetPasswordController;
use App\Http\Controllers\Boilerplate\DashboardController;
use App\Http\Controllers\Boilerplate\DatatablesController;
use App\Http\Controllers\Boilerplate\DemoController;
use App\Http\Controllers\Boilerplate\GptController;
use App\Http\Controllers\Boilerplate\ImpersonateController;
use App\Http\Controllers\Boilerplate\LanguageController;
use App\Http\Controllers\Boilerplate\Logs\LogViewerController;
use App\Http\Controllers\Boilerplate\Select2Controller;
use App\Http\Controllers\Boilerplate\Users\RolesController;
use App\Http\Controllers\Boilerplate\Users\UsersController;
use App\Http\Controllers\ApprovisionnementController;
use App\Http\Controllers\ProductionController;
use App\Http\Controllers\RapportController;
use App\Http\Controllers\CommandeController;
use App\Http\Controllers\ProduitController;
use App\Http\Controllers\MatierePremiereController;
use App\Http\Controllers\ApprobationController;
use App\Http\Controllers\FournisseurController;
use App\Http\Controllers\MatierePremieresStockController;
use App\Http\Controllers\ProduitStockController;
use App\Http\Controllers\CategorieController;
use Illuminate\Support\Facades\Route;
use App\Menu\Rapport;

Route::group([
    'prefix'     => config('boilerplate.app.prefix', ''),
    'domain'     => config('boilerplate.app.domain', ''),
    'middleware' => ['web', 'boilerplate.locale'],
    'as'         => 'boilerplate.',
], function () {
    // Logout
    Route::post('logout', [LoginController::class, 'logout'])->name('logout');

    // Language switch
    if (config('boilerplate.locale.switch', false)) {
        Route::post('language', [LanguageController::class, 'switch'])->name('lang.switch');
    }

    // Frontend
    Route::group(['middleware' => ['boilerplate.guest']], function () {
        // Login
        Route::get('login', [LoginController::class, 'showLoginForm'])->name('login');
        Route::post('login', [LoginController::class, 'login'])->name('login.post');

        // Registration
        Route::get('register', [RegisterController::class, 'showRegistrationForm'])->name('register');
        Route::post('register', [RegisterController::class, 'register'])->name('register.post');

        // Password reset
        Route::prefix('password')->as('password.')->group(function () {
            Route::get('request', [ForgotPasswordController::class, 'showLinkRequestForm'])->name('request');
            Route::post('email', [ForgotPasswordController::class, 'sendResetLinkEmail'])->name('email');
            Route::get('reset/{token}', [ResetPasswordController::class, 'showResetForm'])->name('reset');
            Route::post('reset', [ResetPasswordController::class, 'reset'])->name('reset.post');
        });

        // First login
        Route::get('connect/{token?}', [UsersController::class, 'firstLogin'])->name('users.firstlogin');
        Route::post('connect/{token?}', [UsersController::class, 'firstLoginPost'])->name('users.firstlogin.post');
    });

    // Email verification
    Route::prefix('email')->middleware('boilerplate.auth')->as('verification.')->group(function () {
        Route::get('verify', [RegisterController::class, 'emailVerify'])->name('notice');
        Route::get('verify/{id}/{hash}', [RegisterController::class, 'emailVerifyRequest'])->name('verify');
        Route::post('verification-notification', [RegisterController::class, 'emailSendVerification'])->name('send');
    });

    // Backend
    Route::group(['middleware' => ['boilerplate.auth', 'ability:admin,backend_access', 'boilerplate.emailverified']], function () {
        // Impersonate another user
        if (config('boilerplate.app.allowImpersonate', false)) {
            Route::as('impersonate.')->group(function () {
                Route::get('unauthorized', [ImpersonateController::class, 'unauthorized'])->name('unauthorized');
                Route::prefix('impersonate')->group(function () {
                    Route::post('/', [ImpersonateController::class, 'impersonate'])->name('user');
                    Route::get('stop', [ImpersonateController::class, 'stopImpersonate'])->name('stop');
                    Route::post('select', [ImpersonateController::class, 'selectImpersonate'])->name('select');
                });
            });
        }

        // Categories
        Route::get('categories/list', [CategorieController::class, 'index'])->name('categories.index');
        Route::get('categories/create', [CategorieController::class, 'create'])->name('categories.create');
        Route::post('categories/store', [CategorieController::class, 'store'])->name('categories.store');
        Route::get('edit/{id_Categorie}', [CategorieController::class, 'edit'])->name('categories.edit');
        Route::put('update/{id_Categorie}', [CategorieController::class, 'update'])->name('categories.update');
        Route::delete('destroy/{id_Categorie}', [CategorieController::class, 'destroy'])->name('categories.destroy');

        // matierepremieres
        Route::get('matierepremieres/list', [MatierePremiereController::class, 'index'])->name('matierepremieres.index');
        Route::get('matierepremieres/create', [MatierePremiereController::class, 'create'])->name('matierepremieres.create');
        Route::post('matierepremieres/store', [MatierePremiereController::class, 'store'])->name('matierepremieres.store');
        Route::get('matierepremieres/{id_MP}', [MatierePremiereController::class, 'show'])->name('matierepremieres.show');
        Route::get('matierepremieres/{id_MP}/edit', [MatierePremiereController::class, 'edit'])->name('matierepremieres.edit');
        Route::put('matierepremieres/{id_MP}', [MatierePremiereController::class, 'update'])->name('matierepremieres.update');
        Route::delete('matierepremieres/{id_MP}', [MatierePremiereController::class, 'destroy'])->name('matierepremieres.destroy');

        // produits
        Route::get('produits/index', [ProduitController::class, 'index'])->name('produits.index');
        Route::get('produits/create', [ProduitController::class, 'create'])->name('produits.create');
        Route::post('produits/store', [ProduitController::class, 'store'])->name('produits.store');
        Route::get('produits/{id_produit}', [ProduitController::class, 'show'])->name('produits.show');
        Route::get('produits/{id_produit}/edit', [ProduitController::class, 'edit'])->name('produits.edit');
        Route::put('produits/{id_produit}', [ProduitController::class, 'update'])->name('produits.update');
        Route::delete('produits/{id_produit}', [ProduitController::class, 'destroy'])->name('produits.destroy');



        // Approvisionnement Routes
        Route::prefix('approvisionnements')->group(function () {
            Route::get('statistiques', [ApprovisionnementController::class, 'statistiques'])->name('approvisionnements.statistiques');
            Route::get('gerer', [ApprovisionnementController::class, 'index'])->name('approvisionnements.gerer');
            Route::get('create', [ApprovisionnementController::class, 'create'])->name('approvisionnements.create');
            Route::post('store', [ApprovisionnementController::class, 'store'])->name('approvisionnements.store');
            Route::get('details/{id_approvisionnement}', [ApprovisionnementController::class, 'show'])->name('approvisionnements.details');
            Route::get('edit/{id_approvisionnement}', [ApprovisionnementController::class, 'edit'])->name('approvisionnements.edit');
            Route::put('update/{id_approvisionnement}', [ApprovisionnementController::class, 'update'])->name('approvisionnements.update');
            Route::delete('destroy/{id_approvisionnement}', [ApprovisionnementController::class, 'destroy'])->name('approvisionnements.destroy');
        });

        // Fournisseurs
        Route::get('fournisseurs', [FournisseurController::class, 'index'])->name('approvisionnements.fournisseurs');
        Route::get('createfournisseur', [FournisseurController::class, 'create'])->name('approvisionnements.createfournisseur');
        Route::post('store', [FournisseurController::class, 'store'])->name('fournisseurs.store');
        Route::get('show/{id_fournisseur}', [FournisseurController::class, 'show'])->name('fournisseur.show');
        Route::get('editfournisseur/{id_fournisseur}', [FournisseurController::class, 'edit'])->name('fournisseur.edit');
        Route::put('update/{id_fournisseur}', [FournisseurController::class, 'update'])->name('fournisseurs.update');
        Route::delete('destroy/{id_fournisseur}', [FournisseurController::class, 'destroy'])->name('fournisseur.destroy');

        // Productions Routes
        Route::prefix('productions')->group(function () {
            Route::get('statistiques', [ProductionController::class, 'statistiques'])->name('productions.statistiques');
            Route::get('gerer', [ProductionController::class, 'index'])->name('productions.gerer');
            Route::get('create', [ProductionController::class, 'create'])->name('productions.create');
            Route::post('store', [ProductionController::class, 'store'])->name('productions.store');
            Route::get('show/{id_production}', [ProductionController::class, 'show'])->name('productions.show');
            Route::get('edit/{id_production}', [ProductionController::class, 'edit'])->name('productions.edit');
            Route::put('update/{id_production}', [ProductionController::class, 'update'])->name('productions.update');
            Route::delete('destroy/{id_production}', [ProductionController::class, 'destroy'])->name('productions.destroy');
        });

        // Rapport
        Route::get('rapport', [RapportController::class, 'index'])->name('rapport.index');

        // Commandes Routes
        Route::get('commandes/statistiques', [CommandeController::class, 'statistiques'])->name('commande.statistiques');
        Route::get('commandes/gerer', [CommandeController::class, 'index'])->name('commande.gerer');

        // Stocks Routes
        Route::get('stocks/matierespremieres', [MatierePremieresStockController::class, 'index'])->name('stocks.matierespremieres');
        Route::get('stocks/produits', [ProduitStockController::class, 'index'])->name('stocks.produits');

        // Approbations Routes
        Route::get('approbations/index', [ApprobationController::class, 'index'])->name('approbations.index');
        Route::patch('approbations/approuvé/{id}/{type}', [ApprobationController::class, 'approuvé'])->name('approbations.approuvé');
        Route::patch('approbations/rejeté/{id}/{type}', [ApprobationController::class, 'rejeté'])->name('approbations.rejeté');
        Route::get('approbations/gerer', [ApprobationController::class, 'gerer'])->name('approbations.gerer');

        // Dashboard
        Route::get('/', [config('boilerplate.menu.dashboard', DashboardController::class), 'index'])->name('dashboard');
        if (config('boilerplate.dashboard.edition', false)) {
            Route::prefix('dashboard/widget')->as('dashboard.')->group(function () {
                Route::post('add', [DashboardController::class, 'addWidget'])->name('add-widget');
                Route::post('load', [DashboardController::class, 'loadWidget'])->name('load-widget');
                Route::post('edit', [DashboardController::class, 'editWidget'])->name('edit-widget');
                Route::post('update', [DashboardController::class, 'updateWidget'])->name('update-widget');
                Route::post('save', [DashboardController::class, 'saveWidgets'])->name('save-widgets');
            });
        }

        // Components demo page
        Route::get('/demo', [DemoController::class, 'index'])->name('demo');

        // Session keep-alive
        Route::post('keep-alive', [UsersController::class, 'keepAlive'])->name('keepalive');

        // Datatables
        Route::post('datatables/{slug}', [DatatablesController::class, 'make'])->name('datatables');
        Broadcast::channel('dt.{name}.{signature}', function ($user, $name, $signature) {
            return channel_hash_equals($signature, 'dt', $name);
        });

        // Select2
        Route::post('select2', [Select2Controller::class, 'make'])->name('select2');

        // Roles and users
        Route::resource('roles', RolesController::class)->except('show')->middleware(['ability:admin,roles_crud']);
        Route::resource('users', UsersController::class)->middleware('ability:admin,users_crud')->except('show');

        // Profile
        Route::prefix('userprofile')->as('user.')->group(function () {
            Route::get('/', [UsersController::class, 'profile'])->name('profile');
            Route::post('/', [UsersController::class, 'profilePost'])->name('profile.post');
            Route::post('settings', [UsersController::class, 'storeSetting'])->name('settings');
            Route::get('avatar/url', [UsersController::class, 'getAvatarUrl'])->name('avatar.url');
            Route::post('avatar/upload', [UsersController::class, 'avatarUpload'])->name('avatar.upload');
            Route::post('avatar/gravatar', [UsersController::class, 'getAvatarFromGravatar'])->name('avatar.gravatar');
            Route::post('avatar/delete', [UsersController::class, 'avatarDelete'])->name('avatar.delete');
        });

        // ChatGPT
        if (config('boilerplate.app.openai.key')) {
            Route::prefix('gpt')->as('gpt.')->group(function () {
                Route::get('/', [GptController::class, 'index'])->name('index');
                Route::post('/', [GptController::class, 'process'])->name('process');
                Route::get('/stream', [GptController::class, 'stream'])->name('stream');
            });
        }

        // Logs
        if (config('boilerplate.app.logs', false)) {
            Route::prefix('logs')->as('logs.')->middleware('ability:admin,logs')->group(function () {
                Route::get('/', [LogViewerController::class, 'index'])->name('dashboard');
                Route::prefix('list')->group(function () {
                    Route::get('/', [LogViewerController::class, 'listLogs'])->name('list');
                    Route::delete('delete', [LogViewerController::class, 'delete'])->name('delete');
                    Route::prefix('{date}')->group(function () {
                        Route::get('/', [LogViewerController::class, 'show'])->name('show');
                        Route::get('download', [LogViewerController::class, 'download'])->name('download');
                        Route::get('{level}', [LogViewerController::class, 'showByLevel'])->name('filter');
                    });
                });
            });
        }
    });
});
