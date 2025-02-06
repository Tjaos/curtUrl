<?php

namespace App\Http\Controllers;

use App\Models\AccessLog;
use Carbon\Carbon;
use App\Models\Url;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;

class UrlController extends Controller
{
    // Método para criar URL curta
    public function create(Request $request)
    {
        $request->validate([
            'long_url' => 'required|url|unique:urls,long_url',
        ]);

        $shortUrl = Str::random(6);  // Geração simples de URL curta

        $url = Url::create([
            'long_url' => $request->long_url,
            'short_url' => $shortUrl,
            'expires_at' => now()->addDays(30),  // Expiração após 30 dias
            'user_id' => Auth::id(), // Salva o ID do usuário autenticado
        ]);

        return response()->json(['short_url' => url($shortUrl)], 201);
    }

    // Função para apagar links
    public function destroy($id)
    {
        $url = Url::where('id', $id)->where('user_id', Auth::id())->first();

        if (!$url) {
            return redirect()->route('dashboard')->with('error', 'Link não encontrado.');
        }

        $url->delete();
        return redirect()->route('dashboard')->with('success', 'Link excluído com sucesso.');
    }

    // Método para redirecionar a URL curta para a URL longa
    public function redirect($shortUrl)
    {
        // Tente encontrar a URL no cache ou no banco de dados
        $url = Cache::remember("url:$shortUrl", 3600, function () use ($shortUrl) {
            return Url::where('short_url', $shortUrl)->first();
        });

        // Verificar se a URL foi encontrada
        if (!$url) {
            return response()->json(['error' => 'URL não encontrada'], 404);
        }

        // Verificar se a URL expirou
        if ($url->expires_at && Carbon::parse($url->expires_at)->isPast()) {
            return response()->json(['error' => 'URL expirou'], 410); // HTTP 410 Gone
        }

        // Log do acesso
        AccessLog::create([
            'url_id' => $url->id,
            'ip_address' => request()->ip(),
        ]);

        // Redirecionar para a URL longa
        return redirect()->to($url->long_url);
    }

    // Método para exibir o dashboard de monitoramento
    public function dashboard()
    {
        $urls = Url::where('user_id', Auth::id())->withCount('accessLogs')->get();
        return view('dashboard', compact('urls'));
    }
}
