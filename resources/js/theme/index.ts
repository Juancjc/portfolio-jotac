import { definePreset } from '@primeuix/themes';
import Aura from '@primeuix/themes/aura';

/**
 * Tema Juan — Vermelho Premium
 *
 * Identidade visual: energia, autoridade, modernidade e sofisticação.
 * Construído em cima do preset Aura do PrimeVue, com paleta de vermelhos
 * customizada e tonalidades de superfície escuras para o dark mode.
 */
export const JuanTheme = definePreset(Aura, {
    semantic: {
        primary: {
            50:  '#fff1f1',
            100: '#ffdfdf',
            200: '#ffc5c5',
            300: '#ff9d9d',
            400: '#ff6464',
            500: '#ff2d2d',
            600: '#ed1515',
            700: '#c80d0d',
            800: '#a50f0f',
            900: '#881414',
            950: '#4b0404',
        },
        colorScheme: {
            light: {
                primary: {
                    color: '{primary.600}',
                    inverseColor: '#ffffff',
                    hoverColor: '{primary.700}',
                    activeColor: '{primary.800}',
                },
                highlight: {
                    background: '{primary.50}',
                    focusBackground: '{primary.100}',
                    color: '{primary.700}',
                    focusColor: '{primary.800}',
                },
                surface: {
                    0:   '#ffffff',
                    50:  '#fafafa',
                    100: '#f4f4f5',
                    200: '#e4e4e7',
                    300: '#d4d4d8',
                    400: '#a1a1aa',
                    500: '#71717a',
                    600: '#52525b',
                    700: '#3f3f46',
                    800: '#27272a',
                    900: '#18181b',
                    950: '#09090b',
                },
            },
            dark: {
                primary: {
                    color: '{primary.500}',
                    inverseColor: '#0a0a0a',
                    hoverColor: '{primary.400}',
                    activeColor: '{primary.300}',
                },
                highlight: {
                    background: 'color-mix(in srgb, {primary.500}, transparent 85%)',
                    focusBackground: 'color-mix(in srgb, {primary.500}, transparent 76%)',
                    color: '{primary.300}',
                    focusColor: '{primary.200}',
                },
                surface: {
                    0:   '#ffffff',
                    50:  '#fafafa',
                    100: '#f4f4f5',
                    200: '#e4e4e7',
                    300: '#d4d4d8',
                    400: '#a1a1aa',
                    500: '#71717a',
                    600: '#52525b',
                    700: '#3f3f46',
                    800: '#1f1f23',
                    900: '#121216',
                    950: '#0a0a0d',
                },
            },
        },
    },
    components: {
        button: {
            colorScheme: {
                light: {
                    root: {
                        primary: {
                            background: '{primary.600}',
                            hoverBackground: '{primary.700}',
                            activeBackground: '{primary.800}',
                            borderColor: '{primary.600}',
                            hoverBorderColor: '{primary.700}',
                            activeBorderColor: '{primary.800}',
                            color: '#ffffff',
                        },
                    },
                },
                dark: {
                    root: {
                        primary: {
                            background: '{primary.500}',
                            hoverBackground: '{primary.400}',
                            activeBackground: '{primary.600}',
                            borderColor: '{primary.500}',
                            hoverBorderColor: '{primary.400}',
                            activeBorderColor: '{primary.600}',
                            color: '#0a0a0a',
                        },
                    },
                },
            },
        },
        card: {
            colorScheme: {
                dark: {
                    root: {
                        background: '{surface.900}',
                        borderColor: '{surface.800}',
                    },
                },
            },
        },
    },
});

export default JuanTheme;
