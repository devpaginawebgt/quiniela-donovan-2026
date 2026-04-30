<?php

namespace App\Http\Controllers\Auth;

use App\Models\User;
use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\RegisterRequest;
use App\Http\Services\CompanyService;
use App\Http\Services\CountryService;
use App\Http\Services\TermsService;
use App\Http\Services\UserService;
use App\Http\Services\VisitorService;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Http;
use Illuminate\Auth\Events\Registered;
use App\Providers\RouteServiceProvider;
use Illuminate\Http\Request;
class RegisteredUserController extends Controller
{
    public function __construct(
        private readonly CountryService $countryService,
        private readonly CompanyService $companyService,
        private readonly VisitorService $visitorService,
        private readonly TermsService $termsService,
        private readonly UserService $userService,
    ) {}

    /**
     * Display the registration view.
     *
     * @return \Illuminate\View\View
     */
    public function create(Request $request)
    {
        $country = $this->userService->getGuestCountry();

        $companies = $this->companyService->getCompaniesByCountry($country->id);

        $visitors = $this->visitorService->getVisitorsByCountry($country->id);

        $terms = $this->termsService->getTerms();

        return view('modulos.register', compact('country', 'companies', 'visitors', 'terms'));
    }    

    /**
     * Handle an incoming registration request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(RegisterRequest $request)
    {
        $data = $request->validated();

        $pass = config('quiniela.default_pass');
        
        $data['password'] = Hash::make($pass);

        $user = User::create($data);

        $user->assignRole('participant');

        event(new Registered($user));

        Auth::login($user);

        return redirect(RouteServiceProvider::HOME);
        
    }
}