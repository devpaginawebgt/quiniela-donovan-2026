<?php

namespace App\Http\Controllers\Auth;

use App\Models\User;
use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\RegisterRequest;
use App\Http\Services\CompanyService;
use App\Http\Services\CountryService;
use App\Http\Services\TermsService;
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
    ) {}

    /**
     * Display the registration view.
     *
     * @return \Illuminate\View\View
     */
    public function create(Request $request)
    {
        $ip = $request->ip();
        // $ip = '45.164.150.249'; // GT
        // $ip = '190.181.222.119'; // HN

        $country_code = 'GT';

        try {
            $response = Http::timeout(3)->get("http://api.ipinfo.io/lite/{$ip}", [
                'token' => config('services.geolocation.key'),
            ]);

            if ($response->ok() && !empty($response->json('country_code'))) {
                $country_code = $response->json('country_code');
            }
        } catch (\Exception $e) {
            // fallback silencioso, $country_code ya es 'GT'
        }

        $country = $this->countryService->getCountryByCode($country_code)
            ?? $this->countryService->getCountryByCode('GT');

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

        $data['puntos'] = 0;

        $pass = env('DEFAULT_PASS');
        
        $data['password'] = Hash::make($pass);

        $user = User::create($data);

        event(new Registered($user));

        Auth::login($user);

        return redirect(RouteServiceProvider::HOME);
        
    }
}