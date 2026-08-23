<?php

namespace App\Http\Controllers\Install;

use App\Http\Requests\Install\Setting as Request;
use App\Utilities\Installer;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\DB;

class Settings extends Controller
{
    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        return view('install.settings.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  $request
     *
     * @return Response
     */
    public function store(Request $request)
    {
        try {
            DB::transaction(function () use ($request) {
                $locale = session('locale') ?? config('app.locale');

                // Create company
                $company_id = Installer::createCompany($request->get('company_name'), $request->get('company_email'), $locale);

                // Create user
                Installer::createUser($request->get('user_email'), $request->get('user_password'), $locale, $company_id);
            });

            // Make the final touches
            Installer::finalTouches();

            // Redirect to dashboard
            $response['redirect'] = route('login');

            return response()->json($response);
        } catch (\Throwable $e) {
            report($e);

            return response()->json([
                'error' => true,
                'message' => $e->getMessage(),
                'exception' => get_class($e),
                'file' => $e->getFile() . ':' . $e->getLine(),
                'trace' => array_slice(explode("\n", $e->getTraceAsString()), 0, 10),
            ], 500);
        }
    }
}
