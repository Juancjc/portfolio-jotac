<?php

namespace Database\Seeders;

use App\Models\Link;
use App\Models\Profile;
use App\Models\Project;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class PortfolioSeeder extends Seeder
{
    public function run(): void
    {
        $user = User::firstOrCreate(
            ['email' => 'jcjustinianoc@gmail.com'],
            [
                'name'     => 'Juan Carlos Justiniano Coelho',
                'password' => Hash::make('password'),
            ]
        );

        // Perfil
        Profile::updateOrCreate(
            ['user_id' => $user->id],
            [
                'display_name'    => 'Juan Carlos Justiniano Coelho',
                'headline'        => 'Full-Stack Developer & Tech Lead',
                'subtitle'        => 'Crio produtos digitais elegantes, escaláveis e obcecados por performance.',
                'bio'             => 'Sou desenvolvedor full-stack com foco em Laravel, Vue e arquitetura de sistemas modernos. Transformo ideias em produtos reais com design premium, código limpo e experiência de usuário memorável.',
                'github_username' => 'jcjustinianoc',
                'github_url'      => 'https://github.com/jcjustinianoc',
                'linkedin_url'    => 'https://linkedin.com/in/juanjustiniano',
                'email_contact'   => 'jcjustinianoc@gmail.com',
                'location'        => 'Brasil',
                'tech_stack'      => [
                    'Laravel', 'PHP 8.3', 'Vue 3', 'TypeScript', 'PrimeVue',
                    'Tailwind CSS', 'Inertia', 'PostgreSQL', 'MySQL',
                    'Redis', 'Docker', 'AWS', 'Node.js',
                ],
                'experiences'     => [
                    ['role' => 'Tech Lead', 'company' => 'Empresa A', 'period' => '2023 — hoje', 'desc' => 'Liderança técnica e arquitetura de aplicações enterprise.'],
                    ['role' => 'Full-Stack Developer', 'company' => 'Empresa B', 'period' => '2021 — 2023', 'desc' => 'Desenvolvimento de produtos SaaS com Laravel + Vue.'],
                    ['role' => 'Backend Developer', 'company' => 'Empresa C', 'period' => '2019 — 2021', 'desc' => 'APIs de alta performance e integrações.'],
                ],
                'seo_title'       => 'Juan Carlos Justiniano Coelho — Full-Stack Developer',
                'seo_description' => 'Portfólio profissional: projetos, tecnologias e links principais.',
                'theme_accent'    => '#ed1515',
            ]
        );

        // Links principais
        $links = [
            ['title' => 'GitHub',     'description' => 'Meus projetos open-source',   'icon' => 'pi-github',   'type' => 'external', 'url' => 'https://github.com/jcjustinianoc',           'featured' => true,  'sort_order' => 1],
            ['title' => 'LinkedIn',   'description' => 'Conecte-se comigo',            'icon' => 'pi-linkedin', 'type' => 'external', 'url' => 'https://linkedin.com/in/juanjustiniano',     'featured' => true,  'sort_order' => 2],
            ['title' => 'Projetos',   'description' => 'Ver meu portfólio',            'icon' => 'pi-briefcase','type' => 'internal', 'url' => 'home',                                       'featured' => false, 'sort_order' => 3],
            ['title' => 'E-mail',     'description' => 'Vamos conversar',              'icon' => 'pi-envelope', 'type' => 'external', 'url' => 'mailto:jcjustinianoc@gmail.com',            'featured' => false, 'sort_order' => 4],
            ['title' => 'Currículo',  'description' => 'Baixar em PDF',                'icon' => 'pi-file-pdf', 'type' => 'external', 'url' => '/downloads/curriculo.pdf',                   'featured' => false, 'sort_order' => 5],
        ];
        foreach ($links as $l) {
            Link::updateOrCreate(['user_id' => $user->id, 'title' => $l['title']], $l + ['user_id' => $user->id, 'active' => true]);
        }

        // Projetos destaque
        $projects = [
            [
                'title' => 'Plataforma SaaS Enterprise',
                'description' => 'Sistema multi-tenant com Laravel + Vue que escalou de 0 a 10k usuários.',
                'long_description' => 'Arquitetura multi-tenant baseada em filas Redis, jobs assíncronos e cache agressivo. UI construída em PrimeVue com design system custom.',
                'technologies' => ['Laravel', 'Vue 3', 'PrimeVue', 'PostgreSQL', 'Redis', 'Docker'],
                'github_url' => 'https://github.com/jcjustinianoc/saas-enterprise',
                'project_url' => null,
                'featured' => true,
            ],
            [
                'title' => 'API Financial Core',
                'description' => 'API de alta performance para processamento de transações em tempo real.',
                'technologies' => ['Laravel', 'MySQL', 'RabbitMQ', 'Docker'],
                'github_url' => 'https://github.com/jcjustinianoc/financial-core',
                'featured' => true,
            ],
            [
                'title' => 'Dashboard Analytics',
                'description' => 'Dashboard de métricas em tempo real com WebSockets.',
                'technologies' => ['Vue 3', 'TypeScript', 'D3.js', 'Laravel Reverb'],
                'github_url' => 'https://github.com/jcjustinianoc/analytics-dashboard',
                'featured' => true,
            ],
            [
                'title' => 'CLI DevTools',
                'description' => 'Ferramenta de linha de comando para automação de workflows.',
                'technologies' => ['Node.js', 'TypeScript', 'Commander'],
                'github_url' => 'https://github.com/jcjustinianoc/devtools',
                'featured' => false,
            ],
        ];
        $order = 1;
        foreach ($projects as $p) {
            Project::updateOrCreate(
                ['user_id' => $user->id, 'title' => $p['title']],
                array_merge($p, ['user_id' => $user->id, 'published' => true, 'sort_order' => $order++])
            );
        }
    }
}
