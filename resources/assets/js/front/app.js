﻿require('./bootstrap');
import * as VueGoogleMaps from 'vue2-google-maps';

Vue.use( VueGoogleMaps, {
    load: {
        key: FEMR.googleMapsKey,
        libraries: 'places'
    }
});

let Affix = require('vue-affix');
Vue.use(Affix);

import VeeValidate from 'vee-validate';
Vue.use( VeeValidate, { inject: true } );

let VueScrollTo = require('vue-scrollto');
Vue.use( VueScrollTo, {
    container: "body",
    duration: 500,
    easing: "ease",
    offset: -130,
    cancelable: true,
    onCancel: false
});

Vue.component( 'slack-invite', require( './components/SlackInvite.vue' ) );
Vue.component( 'femr-map', require( './components/FemrMap.vue' ) );
Vue.component( 'program-map', require( './components/ProgramMap.vue' ) );
Vue.component( 'copy-to-clipboard', require( './components/CopyToClipboard.vue' ) );
Vue.component( 'survey', require( './components/Survey.vue' ) );
Vue.component( 'text-field', require( './components/fields/TextField.vue' ) );
Vue.component( 'textarea-field', require( './components/fields/TextareaField.vue' ) );
Vue.component( 'select-field', require( './components/fields/SelectField.vue' ) );
Vue.component( 'multi-select-field', require( './components/fields/MultiSelectField.vue' ) );

const app = new Vue({

    el: '#app',
    data(){

        return {
            

        }
    },
    methods: {

        /**
         * Since the homepage is currently a single page, native browser hash scrolling to the
         *  appropriate sections doesn't take into account the offset from the header. Rather than
         *  temporarily doing something odd with css, it seems better to just catch the hash with js
         *  and scroll with the vue-scrollto directive
         */
        scrollToHash(){

            // check the current url for a hash tag, if present scroll to this section
            if( window.location.hash ) {

                // Scroll to the current hash
                this.$scrollTo( window.location.hash );
            }
        },

        /**
         * Bind the menu hide/show actions
         *
         * TODO - vue-ify this code with a component
         *
         */
        setupMobileMenuToggle(){

            // Toggle mobile menu
            let burger = document.querySelector('.nav-toggle');
            let menu = document.querySelector('.nav-menu');
            burger.addEventListener('click', function() {

                burger.classList.toggle('is-active');
                menu.classList.toggle('is-active');
            });

            // hide mobile menu when item is clicked
            let nav = document.querySelector('.nav-right');
            let nav_items = document.querySelectorAll('a.nav-item');
            _.forEach( nav_items, ( nav_item ) => {

                nav_item.addEventListener('click', function() {

                    // If is mobile
                    if( window.innerWidth <= 768 ) {

                        burger.classList.remove('is-active');
                        menu.classList.remove('is-active');
                    }
                });
            });
        }
    },

    created() {

        this.scrollToHash();
    },

    mounted(){

        this.setupMobileMenuToggle();
    }
});