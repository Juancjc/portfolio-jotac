<script setup lang="ts">
import { Head } from '@inertiajs/vue3';
import HeroSection     from '@/components/public/HeroSection.vue';
import LinksSection    from '@/components/public/LinksSection.vue';
import AboutSection    from '@/components/public/AboutSection.vue';
import TechStackSection from '@/components/public/TechStackSection.vue';
import TimelineSection from '@/components/public/TimelineSection.vue';
import ProjectsSection from '@/components/public/ProjectsSection.vue';
import GithubSection   from '@/components/public/GithubSection.vue';
import ContactSection  from '@/components/public/ContactSection.vue';
import FooterSection   from '@/components/public/FooterSection.vue';

const props = defineProps<{
    profile: any;
    banner: any;
    links: any[];
    projects: any[];
    githubStats: any;
    meta: { title?: string | null; description?: string | null };
}>();
</script>

<template>
    <Head>
        <title>{{ meta.title || profile.display_name }}</title>
        <meta name="description" :content="meta.description || profile.subtitle || ''" />
        <meta property="og:title" :content="meta.title || profile.display_name" />
        <meta property="og:description" :content="meta.description || profile.subtitle || ''" />
        <meta property="og:type" content="website" />
        <meta name="theme-color" content="#ed1515" />
    </Head>

    <HeroSection      :profile="profile" :banner="banner" :stats="githubStats" />
    <LinksSection     :links="links" v-if="links?.length" />
    <AboutSection     :profile="profile" />
    <TechStackSection :stack="profile.tech_stack" />
    <ProjectsSection  :projects="projects" />
    <GithubSection    :stats="githubStats" />
    <TimelineSection  :experiences="profile.experiences" />
    <ContactSection   :profile="profile" />
    <FooterSection    :display-name="profile.display_name" :github-url="profile.github_url" />
</template>
