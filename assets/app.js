import Turbolinks from 'turbolinks'
// var Turbolinks = require('turbolinks')
Turbolinks.start()
//document.addEventListener(
//    'turbolinks:load',
//    () => Components.loadAll(),
//   {
//     once: true,
//    },
//  );
//document.addEventListener('turbolinks:render', () =>
//Components.loadAll(),
//);

import TestVue from './customElements/TestVue.ce.vue'
import { defineCustomElement } from 'vue'

const TestElement = defineCustomElement(TestVue)
customElements.define('test-vueelement', TestElement)

// import register from 'preact-custom-element'
// import Hello from './main.jsx'
// register(Hello)
// customElements.define('test-element', Test)

// const tutos = document.getElementById('tutos')

// render(<Hello></Hello>, tutos)

// any CSS you import will output into a single css file (app.css in this case)
import * as Popper from '@popperjs/core'
import * as bootstrap from 'bootstrap'
import './styles/app.scss'

// start the Stimulus application
// import './bootstrap';
