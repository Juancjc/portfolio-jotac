<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        /* -----------------------------------------------------------------
         | profiles — dados "dono" do portfólio
         * ----------------------------------------------------------------- */
        Schema::create('profiles', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->string('display_name')->default('Juan Carlos Justiniano Coelho');
            $table->string('headline')->nullable();           // título principal
            $table->string('subtitle')->nullable();           // subtítulo profissional
            $table->text('bio')->nullable();                  // descrição "Sobre mim"
            $table->string('avatar_path')->nullable();
            $table->string('github_username')->nullable();
            $table->string('github_url')->nullable();
            $table->string('linkedin_url')->nullable();
            $table->string('instagram_url')->nullable();
            $table->string('twitter_url')->nullable();
            $table->string('email_contact')->nullable();
            $table->string('location')->nullable();
            $table->json('social_links')->nullable();         // redes extras
            $table->json('tech_stack')->nullable();           // tecnologias dominadas
            $table->json('experiences')->nullable();          // timeline profissional
            $table->string('seo_title')->nullable();
            $table->text('seo_description')->nullable();
            $table->string('theme_accent', 16)->default('#ed1515');
            $table->timestamps();
        });

        /* -----------------------------------------------------------------
         | banners — banner personalizável (topo da landing)
         * ----------------------------------------------------------------- */
        Schema::create('banners', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->string('title')->nullable();
            $table->string('subtitle')->nullable();
            $table->string('image_path')->nullable();
            $table->string('cta_label')->nullable();
            $table->string('cta_url')->nullable();
            $table->string('overlay_color', 24)->default('#000000');
            $table->unsignedTinyInteger('overlay_opacity')->default(40); // 0-100
            $table->boolean('active')->default(true);
            $table->timestamps();
        });

        /* -----------------------------------------------------------------
         | links — estilo Linktree
         * ----------------------------------------------------------------- */
        Schema::create('links', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->string('title');
            $table->string('description')->nullable();
            $table->string('icon')->nullable();               // classe primeicons ou lucide
            $table->enum('type', ['internal', 'external'])->default('external');
            $table->string('url');                             // URL ou route name
            $table->boolean('featured')->default(false);
            $table->boolean('active')->default(true);
            $table->unsignedInteger('clicks')->default(0);
            $table->unsignedInteger('sort_order')->default(0);
            $table->timestamps();

            $table->index(['user_id', 'active', 'sort_order']);
        });

        /* -----------------------------------------------------------------
         | projects — portfolio de projetos
         * ----------------------------------------------------------------- */
        Schema::create('projects', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->string('title');
            $table->string('slug')->unique();
            $table->text('description')->nullable();
            $table->text('long_description')->nullable();
            $table->string('image_path')->nullable();
            $table->json('technologies')->nullable();
            $table->string('project_url')->nullable();
            $table->string('github_url')->nullable();
            $table->string('demo_url')->nullable();
            $table->boolean('featured')->default(false);
            $table->boolean('published')->default(true);
            $table->unsignedInteger('sort_order')->default(0);
            $table->timestamps();

            $table->index(['user_id', 'published', 'featured', 'sort_order']);
        });

        /* -----------------------------------------------------------------
         | link_clicks — tracking básico (analytics)
         * ----------------------------------------------------------------- */
        Schema::create('link_clicks', function (Blueprint $table) {
            $table->id();
            $table->foreignId('link_id')->constrained()->cascadeOnDelete();
            $table->string('referrer')->nullable();
            $table->string('ip', 45)->nullable();
            $table->string('user_agent')->nullable();
            $table->string('country', 8)->nullable();
            $table->timestamp('clicked_at')->useCurrent();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('link_clicks');
        Schema::dropIfExists('projects');
        Schema::dropIfExists('links');
        Schema::dropIfExists('banners');
        Schema::dropIfExists('profiles');
    }
};
