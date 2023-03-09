import { defineConfig } from 'vite'
import symfonyPlugin from 'vite-plugin-symfony'
import vue from '@vitejs/plugin-vue'
import path from 'path'

/* if you're using React */
// import react from '@vitejs/plugin-react';

export default defineConfig({
	resolve: {
		alias: {
			'~bootstrap': path.resolve(__dirname, 'node_modules/bootstrap'),
		},
	},

	plugins: [
		/* react(), // if you're using React */
		symfonyPlugin(),
		vue(),
	],
	build: {
		rollupOptions: {
			input: {
				app: './assets/app.js',
			},
		},
	},
})
