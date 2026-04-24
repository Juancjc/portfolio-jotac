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
            ['email' => 'juancjc@yahoo.com'],
            [
                'name'     => 'Juan CJC',
                'password' => Hash::make('password'),
            ]
        );

        // Perfil
        Profile::updateOrCreate(
            ['user_id' => $user->id],
            [
                'display_name'    => 'Juan CJC',
                'headline'        => 'Full-Stack Developer & University Professor',
                'subtitle'        => 'Crio produtos digitais elegantes, escaláveis e estudo constante para aprender e repassar conhecimento.',
                'bio'             => 'Sou desenvolvedor full-stack com foco em Laravel e Vue JS. Transformo ideias em produtos reais com design premium, código limpo e experiência de usuário memorável.',
                'github_username' => 'Juancjc',
                'github_url'      => 'https://github.com/Juancjc',
                'linkedin_url'    => 'https://www.linkedin.com/in/juan-carlos-justiniano-coelho-920953192/',
                'email_contact'   => 'juancjc@yahoo.com',
                'location'        => 'Brasil',
                'tech_stack'      => [
                    'Laravel', 'PHP 8.3', 'Vue 3', 'TypeScript', 'PrimeVue',
                    'Tailwind CSS', 'Inertia', 'PostgreSQL', 'MySQL',
                    'Redis', 'Docker', 'Node.js',
                ],
                'experiences' => [
                    [
                        'role' => 'Professor',
                        'company' => 'Centro Universitário Uninorte',
                        'period' => 'abr de 2025 — hoje',
                        'desc' => 'Atuação como professor em regime de meio período, com atividades presenciais e híbridas em Rio Branco, Acre.',
                    ],
                    [
                        'role' => 'Desenvolvedor Pleno',
                        'company' => 'VINT Global',
                        'period' => 'jan de 2025 — hoje',
                        'desc' => 'Desenvolvimento de aplicações utilizando Laravel, PostgreSQL e tecnologias web modernas.',
                    ],
                    [
                        'role' => 'Desenvolvedor Pleno',
                        'company' => 'LAMPP-IT SOLUTIONS',
                        'period' => 'nov de 2024 — jan de 2025',
                        'desc' => 'Atuação como desenvolvedor pleno em projetos presenciais, com foco em sistemas web, Laravel e PostgreSQL.',
                    ],
                    [
                        'role' => 'Desenvolvedor Júnior',
                        'company' => 'LAMPP-IT SOLUTIONS',
                        'period' => 'jan de 2024 — nov de 2024',
                        'desc' => 'Desenvolvimento e manutenção de sistemas web, APIs e funcionalidades utilizando Laravel, PostgreSQL e tecnologias relacionadas.',
                    ],
                    [
                        'role' => 'Assistente Técnico de TI',
                        'company' => 'Cadastro Ambiental Rural do Acre',
                        'period' => 'ago de 2022 — jan de 2024',
                        'desc' => 'Suporte técnico, análise de dados, apoio operacional e utilização de ferramentas como Microsoft Power BI e Microsoft Office.',
                    ],
                    [
                        'role' => 'Suporte Técnico',
                        'company' => 'Secretaria da Educação e Esporte do Acre',
                        'period' => 'jun de 2018 — dez de 2018',
                        'desc' => 'Atuação com suporte técnico, atendimento a usuários, manutenção básica e apoio às demandas de TI.',
                    ],
                ],
                'seo_title'       => 'Juan CJC — Full-Stack Developer',
                'seo_description' => 'Portfólio profissional: projetos, tecnologias e links principais.',
                'theme_accent'    => '#ed1515',
            ]
        );

        // Links principais
        $links = [
            ['title' => 'GitHub',     'description' => 'Meus projetos open-source',   'icon' => 'pi-github',   'type' => 'external', 'url' => 'https://github.com/Juancjc',           'featured' => true,  'sort_order' => 1],
            ['title' => 'LinkedIn',   'description' => 'Conecte-se comigo',            'icon' => 'pi-linkedin', 'type' => 'external', 'url' => 'https://www.linkedin.com/in/juan-carlos-justiniano-coelho-920953192/',     'featured' => true,  'sort_order' => 2],
            ['title' => 'Projetos',   'description' => 'Ver meu portfólio',            'icon' => 'pi-briefcase','type' => 'internal', 'url' => 'home',                                       'featured' => false, 'sort_order' => 3],
            ['title' => 'E-mail',     'description' => 'Vamos conversar',              'icon' => 'pi-envelope', 'type' => 'external', 'url' => 'mailto:juancjc@yahoo.com',            'featured' => false, 'sort_order' => 4],
            ['title' => 'Currículo',  'description' => 'Baixar em PDF',                'icon' => 'pi-file-pdf', 'type' => 'external', 'url' => '/downloads/curriculo.pdf',                   'featured' => false, 'sort_order' => 5],
        ];
        foreach ($links as $l) {
            Link::updateOrCreate(['user_id' => $user->id, 'title' => $l['title']], $l + ['user_id' => $user->id, 'active' => true]);
        }

        // Projetos destaque
        $projects = [
            [
                'title' => 'Vue Status Dev',
                'description' => 'Aplicação em Vue para acompanhamento visual de status, serviços ou ambientes de desenvolvimento.',
                'long_description' => 'Projeto público desenvolvido com Vue, focado em exibir informações de status de forma organizada, moderna e responsiva. Pode ser utilizado como base para painéis de monitoramento, páginas de status ou dashboards simples.',
                'technologies' => ['Vue 3', 'JavaScript', 'CSS', 'Vite'],
                'github_url' => 'https://github.com/Juancjc/vue-status-dev',
                'project_url' => null,
                'featured' => true,
            ],
            [
                'title' => 'Sistema Web Administrativo — Nome Confidencial',
                'description' => 'Projeto real desenvolvido em ambiente corporativo, com nome não divulgado por questões de confidencialidade.',
                'long_description' => 'Sistema desenvolvido com Laravel e Vue, envolvendo módulos de CRUD, formulários dinâmicos, listagens, filtros, autenticação, controle de permissões, consumo de APIs e organização de regras de negócio no backend. O nome real do projeto não pode ser informado por questões de confidencialidade.',
                'technologies' => ['Laravel', 'Vue 3', 'PostgreSQL', 'APIs REST', 'Docker'],
                'github_url' => null,
                'project_url' => null,
                'featured' => true,
            ],
            [
                'title' => 'Plataforma de Serviços Digitais — Nome Confidencial',
                'description' => 'Projeto real de plataforma web, com nome protegido por confidencialidade.',
                'long_description' => 'Plataforma com área pública e painel administrativo, incluindo cadastro de informações, gerenciamento de conteúdos, consultas, integração com APIs, organização de dados e estrutura modular para expansão de funcionalidades. O nome real do projeto não pode ser divulgado por estar vinculado a regras de confidencialidade.',
                'technologies' => ['Laravel', 'Vue 3', 'Blade', 'PostgreSQL', 'APIs REST'],
                'github_url' => null,
                'project_url' => null,
                'featured' => true,
            ],
            [
                'title' => 'Sistema de Integrações e APIs — Nome Confidencial',
                'description' => 'Projeto real focado em integrações, APIs e comunicação entre sistemas, com nome não divulgado.',
                'long_description' => 'Desenvolvimento de APIs REST, rotinas de integração, autenticação por token, tratamento de dados, estruturação de services no Laravel e comunicação com sistemas internos e externos. O nome real do sistema não pode ser informado por questões de confidencialidade profissional.',
                'technologies' => ['Laravel', 'PHP', 'PostgreSQL', 'APIs REST', 'JSON'],
                'github_url' => null,
                'project_url' => null,
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
