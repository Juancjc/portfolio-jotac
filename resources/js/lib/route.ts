/**
 * Mini route helper — usa nomes de rota e retorna URL.
 * Substitui Ziggy sem adicionar dependência. Apenas rotas
 * referenciadas no frontend precisam estar listadas aqui.
 */
type RouteMap = Record<string, string | ((...p: any[]) => string)>;

const routes: RouteMap = {
    'home':                     '/',
    'login':                    '/login',
    'register':                 '/register',
    'logout':                   '/logout',

    'admin.dashboard':          '/admin',
    'admin.profile.edit':       '/admin/profile',
    'admin.profile.update':     '/admin/profile',
    'admin.banner.edit':        '/admin/banner',
    'admin.banner.update':      '/admin/banner',
    'admin.banner.destroy':     '/admin/banner',
    'admin.links.index':        '/admin/links',
    'admin.links.store':        '/admin/links',
    'admin.links.reorder':      '/admin/links/reorder',
    'admin.links.update':       (id: number | string) => `/admin/links/${id}`,
    'admin.links.destroy':      (id: number | string) => `/admin/links/${id}`,
    'admin.projects.index':     '/admin/projects',
    'admin.projects.store':     '/admin/projects',
    'admin.projects.update':    (id: number | string) => `/admin/projects/${id}`,
    'admin.projects.destroy':   (id: number | string) => `/admin/projects/${id}`,
};

export function route(name: string, params?: any): string {
    const r = routes[name];
    if (typeof r === 'function') return r(params);
    if (typeof r === 'string')  return r;
    console.warn(`[route] nome desconhecido: ${name}`);
    return '/';
}

// Expõe globalmente para compatibilidade com templates {{ route(...) }}
if (typeof window !== 'undefined') {
    (window as any).route = route;
}
