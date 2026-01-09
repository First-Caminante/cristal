<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class AdminHomeController extends Controller
{
    private function getJsonPath()
    {
        return storage_path('app/home_content.json');
    }

    public function edit()
    {
        $content = $this->getContent();

        // Get list of images in storage/app/public/home
        $files = Storage::disk('public')->files('home');
        $images = [];
        foreach ($files as $file) {
            if (in_array(strtolower(pathinfo($file, PATHINFO_EXTENSION)), ['jpg', 'jpeg', 'png', 'gif', 'webp'])) {
                $images[] = $file;
            }
        }

        return view('admin.home.edit', compact('content', 'images'));
    }

    public function upload(Request $request)
    {
        $request->validate([
            'image' => 'required|image|max:10240', // 10MB
        ]);

        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('home', 'public');
            return response()->json([
                'success' => true,
                'path' => $path,
                'url' => asset('storage/' . $path)
            ]);
        }

        return response()->json(['success' => false], 400);
    }

    public function update(Request $request)
    {
        \Illuminate\Support\Facades\Log::info('Update Home Request', $request->all());

        $request->validate([
            'hero_title' => 'required|string|max:255',
            'hero_text' => 'required|string',
            'hero_image_existing' => 'nullable|string',
            'featured_title' => 'required|string|max:255',
            'featured_description' => 'required|string',
            'featured_image_existing' => 'nullable|string',
            'featured_benefits' => 'nullable|array',
            'featured_benefits.*' => 'nullable|string|max:255',
        ]);

        $content = $this->getContent();

        // Update text fields
        $content['hero']['title'] = $request->hero_title;
        $content['hero']['text'] = $request->hero_text;
        $content['featured']['title'] = $request->featured_title;
        $content['featured']['description'] = $request->featured_description;

        if ($request->has('featured_benefits')) {
            $content['featured']['benefits'] = array_values(array_filter($request->featured_benefits));
        }

        // Handle Hero Image (Path only)
        if ($request->filled('hero_image_existing')) {
            $content['hero']['image'] = $request->hero_image_existing;
        }

        // Handle Featured Image (Path only)
        if ($request->filled('featured_image_existing')) {
            $content['featured']['image'] = $request->featured_image_existing;
        }

        // Save to JSON
        \Illuminate\Support\Facades\Log::info('Saving Content to JSON', ['content' => $content]);
        file_put_contents($this->getJsonPath(), json_encode($content, JSON_PRETTY_PRINT));

        return redirect()->route('admin.home.edit')->with('success', 'Contenido actualizado exitosamente.');
    }

    private function getContent()
    {
        $path = $this->getJsonPath();
        $content = null;

        if (file_exists($path)) {
            $content = json_decode(file_get_contents($path), true);
        }

        // If content is null (empty file) or not an array, use defaults
        if (!is_array($content)) {
            return [
                'hero' => [
                    'title' => 'Industrias Cristal',
                    'text' => 'Cosméticos de calidad premium para tu cuidado personal. Descubre nuestra línea completa de productos para el cabello y la piel.',
                    'image' => 'home/default_hero.jpg',
                ],
                'featured' => [
                    'title' => 'Shampoo Cristal Premium',
                    'description' => 'Nuestro producto más icónico que ha conquistado miles de hogares. Con fórmula enriquecida que nutre profundamente tu cabello, dejándolo suave, brillante y saludable desde la primera aplicación.',
                    'image' => 'home/default_featured.jpg',
                    'benefits' => [
                        'Nutre e hidrata profundamente',
                        'Protección contra el daño diario',
                        'Brillo y suavidad instantáneos'
                    ]
                ]
            ];
        }

        return $content;
    }
}
