<script setup>
import Frontend from '@/Layouts/Frontend.vue';
import { Head, Link } from '@inertiajs/vue3';
import Hero from "@/Components/Frontend/Hero.vue";
import Promote from '@/Components/Frontend/Promote.vue';
import About from "@/Components/Frontend/About.vue";
import Skills from "@/Components/Frontend/Skills.vue";
import Portfolio from "@/Components/Frontend/Portfolio.vue";
/*import Services from "@/Components/Frontend/Services.vue";
import ContactMe from "../Components/Frontend/ContactMe.vue"; */


defineProps({
    canLogin: {
        type: Boolean,
    },
    canRegister: {
        type: Boolean,
    },
    laravelVersion: {
        type: String,
        required: true,
    },
    phpVersion: {
        type: String,
        required: true,
    },
    skills:Object,
    projects:Object
});

function handleImageError() {
    document.getElementById('screenshot-container')?.classList.add('!hidden');
    document.getElementById('docs-card')?.classList.add('!row-span-1');
    document.getElementById('docs-card-content')?.classList.add('!flex-row');
    document.getElementById('background')?.classList.add('!hidden');
}

</script>

<template>
    <Head title="Welcome to Portfolio" />
    <Frontend>
    <!--Hero Primary--->
    <hero/>
    <!--promote tail-100-->
    <Promote/>
    <!--About Secondary-->
    <About/>
    <!--Skills tail-100-->
    <Skills :skills="skills" />
    <!--Portfolio Primary-->
    <Portfolio :skills="skills" :projects="projects"/>
    <!--Services Secondary-->

    <!--Contact primary-->



    </Frontend>

</template>
