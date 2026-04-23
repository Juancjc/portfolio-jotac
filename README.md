# Portfólio — Juan Carlos Justiniano Coelho

Portfólio profissional construído como produto real, com visual **premium em tons de vermelho**, identidade forte e foco em GitHub + projetos.

**Stack:** Laravel 13 · PHP 8.3 · Vue 3 · Inertia · PrimeVue 4 · Tailwind CSS 4 · Vite · SQLite/PostgreSQL.

---

## 1. Setup

```bash
# 1. Dependências
composer install
npm install

# 2. Env
cp .env.example .env
php artisan key:generate
php artisan storage:link

# 3. Banco (SQLite, fica na raiz database/database.sqlite)
touch database/database.sqlite
php artisan migrate --seed

# 4. Dev
php artisan serve          # backend em http://localhost:8000
npm run dev                # Vite em http://localhost:5173
```

Login padrão criado pelo seeder:

- **Email:** `jcjustinianoc@gmail.com`
- **Senha:** `password`

Rotas principais:

| Rota             | Descrição                                     |
|------------------|-----------------------------------------------|
| `/`              | Landing page pública                          |
| `/l/{link}`      | Redirect com tracking de clicks               |
| `/login`         | Fortify — autenticação                         |
| `/admin`         | Dashboard (autenticado)                        |
| `/admin/links`   | CRUD + drag-drop de links (Linktree)           |
| `/admin/projects`| CRUD de projetos com upload de imagem          |
| `/admin/banner`  | Editor de banner com preview em tempo real     |
| `/admin/profile` | Editor do perfil, redes sociais, experiências  |

---

## 2. Arquitetura & pastas

```
app/
├── Http/Controllers/
│   ├── PublicPortfolioController.php    # Landing pública + /l/{link}
│   └── Admin/
│       ├── DashboardController.php
│       ├── LinkController.php           # CRUD + reorder
│       ├── ProjectController.php        # CRUD + upload
│       ├── BannerController.php         # update / destroy
│       └── ProfileController.php
└── Models/
    ├── Profile.php    Banner.php    Link.php    LinkClick.php    Project.php    User.php

database/
├── migrations/2026_04_22_000001_create_portfolio_tables.php
└── seeders/PortfolioSeeder.php          # dados iniciais bonitos

resources/
├── css/app.css                          # tokens Juan + utilitários premium
├── js/
│   ├── app.ts                           # Inertia + PrimeVue + theme
│   ├── theme/index.ts                   # Preset Aura customizado em vermelho
│   ├── layouts/
│   │   ├── PublicLayout.vue             # navbar flutuante com glass
│   │   └── AdminLayout.vue              # sidebar com drawer mobile
│   ├── pages/
│   │   ├── public/Home.vue              # monta todas as seções
│   │   └── admin/{Dashboard,Links,Projects,Banner,Profile}.vue
│   └── components/public/
│       ├── HeroSection.vue              # Hero com mesh + avatar card flutuante
│       ├── LinksSection.vue             # Linktree-style
│       ├── AboutSection.vue             # biografia + code card
│       ├── TechStackSection.vue         # grid de tecnologias
│       ├── TimelineSection.vue          # experiências profissionais
│       ├── ProjectsSection.vue          # cards com filtro All/Featured
│       ├── GithubSection.vue            # SEÇÃO DE DESTAQUE MÁXIMO
│       ├── ContactSection.vue           # CTA + redes sociais
│       └── FooterSection.vue

routes/web.php                           # rotas públicas + /admin com middleware
```

### Fluxo de dados
- **Inertia** entrega o HTML inicial com as props já montadas — zero fetches extras no first paint.
- **GitHub API** é consumida server-side com **cache de 30min** (`Cache::remember`), evitando rate-limit.
- **Link clicks** são registrados via redirect em `/l/{link}`, incrementando contador e gravando analytics.

---

## 3. Tema visual — Vermelho Premium

### Tokens CSS (`resources/css/app.css`)
```css
--juan-red-500: #ff2d2d;
--juan-red-600: #ed1515;   /* cor principal */
--juan-red-700: #c80d0d;
--juan-red-800: #a50f0f;
--juan-red-900: #881414;
--juan-bg-hero: radial gradient mesh com vermelho + preto
--juan-glow:    sombra vermelha para CTAs premium
```

Utilitários prontos: `text-gradient-red`, `bg-hero-mesh`, `shadow-glow-red`, `grid-dots`, `grid-lines`, `glass`, `hover-lift`, `hover-tilt`, `animate-float`, `animate-pulse-red`, `animate-blob-slow`.

### PrimeVue (`resources/js/theme/index.ts`)
Preset `Aura` customizado com a paleta vermelha acima e ajustes em botões/cards para light e dark. Dark mode via classe `.dark` (Tailwind 4 + PrimeVue em sync).

---

## 4. Layout — destaques do design

- **Hero:** mesh radial + grid de linhas + dois blobs animados, avatar card flutuante com mini-stats, chips de tech, CTAs com glow vermelho e badges flutuantes (*Laravel × Vue 3*, *Premium UI/UX*).
- **Linktree:** cards com ícone PrimeIcons, shine animado no hover, selo **Destaque** para itens prioritários, redirect rastreado via `/l/{id}`.
- **Projetos:** cards com imagem, chips de tecnologias, filtro All/Featured em pill-toggle, overlay com botões *Ver projeto* / *GitHub* no hover.
- **GitHub:** seção com background quase preto, grid lines densas, blob vermelho gigante, 4 cards de estatísticas (repos, seguidores, seguindo, gists) puxados da API, card de perfil flutuante com shadow vermelha de 100px e CTA branco grande "Acessar meu GitHub".
- **Timeline:** lista vertical com pulse-dots vermelhos e pill do período.
- **Contato:** CTA card com glow, botão de email + grid de redes sociais.

Tudo **mobile-first**: breakpoints `sm/md/lg` em todos os componentes, sidebar admin vira drawer abaixo de `lg`.

---

## 5. Melhorias sugeridas (além do escopo)

Algumas já vieram implementadas:

- [x] **Dark mode** com toggle no header + auto-detection.
- [x] **SEO básico** (meta title, description, og:title, og:description, theme-color).
- [x] **Animações** com @keyframes custom (float, pulse-red, shine, blob).
- [x] **Tracking de cliques** com tabela `link_clicks` + IP/UA/referrer.
- [x] **GitHub stats cacheado** (30min) via `Http::get` + `Cache::remember`.
- [x] **Timeline profissional** baseada em JSON de `experiences`.
- [x] **Stack section** com ícones e hover.

Para evoluir o produto:

- **RSS/Blog em Markdown** para posts técnicos (usar `spatie/laravel-markdown`).
- **Feed automático de repositórios** (trending, linguagem, stars).
- **Grafo de contribuições** do GitHub embutido (`github-contrib-graph`).
- **Open Graph dinâmico** via `Spatie\Browsershot` gerando imagem do hero.
- **Sitemap.xml + robots.txt** com `spatie/laravel-sitemap`.
- **I18n** (pt-br / en) via `vue-i18n`.
- **A11y**: skip-links, foco visível vermelho, aria-labels em botões de ícone (já começado).
- **PWA** com `vite-plugin-pwa` para instalar no mobile.
- **Throttling** em `/l/{link}` para evitar inflação artificial.
- **Export** de clicks em CSV pelo dashboard.

---

## 6. Comandos úteis

```bash
# recompilar assets
npm run build

# ssr build
npm run build:ssr

# pint (linter PHP)
./vendor/bin/pint

# pest (testes)
./vendor/bin/pest

# reset DB
php artisan migrate:fresh --seed
```

---

Construído com 💪 por **Juan Carlos Justiniano Coelho** — Laravel + Vue + PrimeVue.
