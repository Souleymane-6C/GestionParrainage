<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Candidat;
use App\Models\CodeSecurite;
use App\Models\SuiviParrainage;
use Illuminate\Support\Facades\Mail;
use App\Mail\CodeSecuriteMail;
use Twilio\Rest\Client;
use Illuminate\Support\Facades\Session;
use App\Models\PeriodeParrainage;
use Illuminate\Support\Facades\Log;
use App\Models\Parrainage;

class CandidatController extends Controller

{


/**
 * Afficher le formulaire de connexion
 */
public function showLoginForm()
{
    return view('candidat.login');
}

/**
 * Authentifier le candidat avec l'email et le code de sécurité
 */
public function authenticate(Request $request)
{
    $request->validate([
        'email' => 'required|email|exists:candidats,email',
        'code' => 'required|string|size:6',
    ]);

    // Vérifier si l'email et le code correspondent
    $candidat = Candidat::where('email', $request->email)->first();
    
    if (!$candidat) {
        return back()->with('error', 'Candidat non trouvé.');
    }

    $codeValide = CodeSecurite::where('candidat_id', $candidat->id)
                              ->where('code', $request->code)
                              ->first();

    if (!$codeValide) {
        return back()->with('error', 'Code invalide ou expiré.');
    }

    // Authentification réussie, stocker l'ID dans la session
    session(['candidat_id' => $candidat->id]);

    return redirect()->route('candidat.liste', $candidat->id)->with('success', 'Connexion réussie !');
}

/**
 * Déconnecter le candidat
 */
public function logout(Request $request)
{
    $request->session()->invalidate();
    $request->session()->regenerateToken();
    return redirect()->route('candidat.login')->with('success', 'Déconnexion réussie.');
}





 // Voir l'évolution des parrainages du candidat
 public function index($id)
 {
     $candidat = Candidat::findOrFail($id);
     $parrainages = Parrainage::where('candidat_id', $id)
                             ->selectRaw('DATE(created_at) as date, COUNT(*) as nombre')
                             ->groupBy('date')
                             ->orderBy('date', 'DESC')
                             ->get();

     return view('candidats.suivi', compact('candidat', 'parrainages'));
 }







    public function searchForm()
    {
        return view('candidat.inscription');
    }
    
    public function accueil()
    {
        return view('candidat.accueil');
    }
    public function liste()
{
    $candidats = Candidat::all(); // Récupère tous les candidats
    return view('candidat.liste', compact('candidats')); // Envoie les candidats à la vue
}

    public function suivi()
    {
        return view('candidat.suivi');
    }
    
    
    
  //  public function showLoginForm()
//{
  //  return view('candidat.inscription');
//}

public function showCodeVerificationPage($id)
{
    $candidat = Candidat::findOrFail($id);
    $codeSecurite = CodeSecurite::where('candidat_id', $candidat->id)->first();

    return view('candidat.verification_code_details', compact('candidat', 'codeSecurite'));
}



public function details($id)
{
    // Vérifier si un candidat est en session
    if (!session()->has('candidat_id')) {
        return redirect()->route('candidat.login')->with('error', 'Vous devez être connecté.');
    }

    // Récupérer le candidat en session
    $candidatSession = session('candidat_id');

    // Vérifier si l'utilisateur essaie de voir les détails d'un autre candidat
    if ($candidatSession != $id) {
        return back()->with('error', 'Vous ne pouvez pas voir les détails des autres candidats.');
    }

    // Récupérer les informations du candidat
    $candidat = Candidat::findOrFail($id);

    return view('candidat.details', compact('candidat'));
}


    

    /**
     * Vérifier si le candidat est présent dans la base des candidats et afficher ses informations
     */
    public function verifyCandidat(Request $request)
    {
        $request->validate([
            'numero_carte' => 'required|string',
        ]);
     
// Vérifier si la période de parrainage a commencé
$periode = PeriodeParrainage::latest()->first();
if ($periode && now()->greaterThanOrEqualTo($periode->date_debut)) {
    return back()->with('error', 'Les inscriptions des candidats sont fermées, car la période de parrainage a commencé.');
}

        $candidat = Candidat::where('numero_carte', $request->numero_carte)->first();

        if (!$candidat) {
            return back()->with('error', 'Le candidat considéré n’est pas présent dans la base des candidats.');
        }

        if ($candidat->email) {
            return back()->with('error', 'Candidat déjà enregistré !');
        }

        Session::put('candidat', [
            'id' => $candidat->id,
            'nom' => $candidat->nom,
            'prenom' => $candidat->prenom,
            'date_naissance' => $candidat->date_naissance
        ]);

        return redirect()->route('candidat.complement.form', $candidat->id);
    }


    public function complementForm($id)
{
    $candidat = Candidat::findOrFail($id);
    return view('candidat.complement', compact('candidat'));
}

    /**
     * Finaliser l'inscription du candidat en enregistrant ses informations complémentaires
     */
    public function finalizeCandidat(Request $request, $id)
    {
        $request->validate([
            'email' => 'required|email|unique:candidats,email',
            'telephone' => 'required|unique:candidats,telephone',
            'parti_politique' => 'nullable|string',
            'slogan' => 'nullable|string',
            'photo' => 'required|image|max:2048',
            'couleur_1' => 'required|string',
            'couleur_2' => 'required|string',
            'couleur_3' => 'required|string',
            'url_info' => 'nullable|url',
        ]);

        

        $candidat = Candidat::findOrFail($id);
        $data = $request->except('photo');

        // Gestion de la photo de profil
        if ($request->hasFile('photo')) {
            $data['photo'] = $request->file('photo')->store('candidats', 'public');
        }

        $candidat->update($data);
       

        // Générer et envoyer un code de sécurité
        $code = rand(100000, 999999);
         $newcode=$code;
       CodeSecurite::updateOrCreate(
    ['candidat_id' => $candidat->id],
    ['code' => $code,
    'newcode'=>$code]
);


        // 📧 Envoi du code par email
        Mail::to($candidat->email)->send(new CodeSecuriteMail($code));

        // 📲 Envoi du code par SMS
        $this->sendSms($candidat->telephone, "Votre code de sécurité est : $code");

      // ✅ 🔄 Redirection vers la page de vérification avec un message
    return redirect()->route('candidat.verification_code', $candidat->id)
    ->with('success', 'Inscription réussie ! Un code de sécurité vous a été envoyé par email et SMS.');
    }

    /**
     * Générer un nouveau code de sécurité et l'envoyer par email et SMS
     */
    public function genererNouveauCode($id)
{

      // Vérifier si un candidat est en session
      if (!session()->has('candidat_id')) {
        return redirect()->route('candidat.login')->with('error', 'Vous devez être connecté.');
    }

    // Récupérer le candidat en session
    $candidatSession = session('candidat_id');

    // Vérifier si l'utilisateur essaie de générer un code pour un autre candidat
    if ($candidatSession != $id) {
        return back()->with('error', 'Vous ne pouvez pas générer un code pour un autre candidat.');
    }
    $candidat = Candidat::findOrFail($id);

    // Générer un nouveau code de sécurité
    $newcode = rand(100000, 999999);

    // Récupérer l'enregistrement existant ou en créer un
    $codeSecurite = CodeSecurite::updateOrCreate(
        ['candidat_id' => $candidat->id],
        ['expiration' => now()->addMinutes(10)]
    );

    // 🔥 Forcer la mise à jour de `newcode`
    $codeSecurite->forceFill(['newcode' => $newcode])->save();

    // 📧 Envoi du code par email
    Mail::to($candidat->email)->send(new CodeSecuriteMail("Bonjour,
    Votre code temporaire est : $newcode
    Ce code est valable pendant 10 minutes.
    Cordialement,
    L'équipe de la Direction Générale des Élections"
    ));

    // 📲 Envoi du code par SMS
    $this->sendSms($candidat->telephone, "Votre nouveau code de sécurité est : $newcode");

    return back()->with('success', 'Un nouveau code de sécurité a été envoyé par email et SMS.');
}

    public function verificationCode($id)
    {
        $candidat = Candidat::findOrFail($id);
        return view('candidat.verification_code', compact('candidat'));
    }
    public function validerCodeCandidat(Request $request, $id)
{
    $request->validate([
        'code' => 'required|string|size:6',
    ]);

    $candidat = Candidat::findOrFail($id);
    $codeValide = CodeSecurite::where('candidat_id', $candidat->id)
                              ->where('code', $request->code)
                              ->first();

    if (!$codeValide) {
        return back()->with('error', 'Code invalide ou expiré.');
    }

   

    // Rediriger vers la page de détails du candidat
    return redirect()->route('candidat.liste', $candidat->id)
                     ->with('success', 'Authentification réussie !');
}



    /**
     * Fonction d'envoi de SMS via Twilio
     */
    private function sendSms($telephone, $message)
    {
        try {
            $sid = env('AC0239e45fa76d7ce36f061bc31e234ea0');
            $token = env('398d1dcd5b59ffee4f334508c44002b9');
            $twilioNumber = env('778504096');

            $client = new Client($sid, $token);
            $client->messages->create(
                $telephone,
                [
                    'from' => $twilioNumber,
                    'body' => $message
                ]
            );
        } catch (\Exception $e) {
            Log::error("Erreur lors de l'envoi du SMS : " . $e->getMessage());
        }
    }
    public function verifyCodeForDetails(Request $request)
    {
        $request->validate([
            'newcode' => 'required|string|size:6',
        ]);
    
        //if (!session()->has('candidat_id')) {
          //  return redirect()->route('candidat.login')->with('error', 'Vous devez être connecté.');
        //}
    
        $candidat = Candidat::findOrFail(session('candidat_id'));
    
        $codeValide = CodeSecurite::where('candidat_id', $candidat->id)
                                  ->where('newcode', $request->newcode)
                                  ->where('expiration', '>=', now())
                                  ->first();
    
        if (!$codeValide) {
            return back()->with('error', 'Code invalide ou expiré.');
        }
    
        // ✅ Supprimer seulement `newcode` après validation
        $codeValide->update(['newcode' => null, 'expiration' => null]);
    
        return redirect()->route('candidat.details', ['id' => $candidat->id]);
    }
    
}
