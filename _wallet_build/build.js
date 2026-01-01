const esbuild = require('esbuild');

esbuild.build({
    entryPoints: ['reown-init.js'],
    bundle: true,
    outfile: '../app/assets/scripts/reown-bundle.js',
    format: 'iife',     // Immediately Invoked Function Expression for direct browser use
    target: ['es2020'], // Modern JS target
    minify: true,       // Minify for production
    sourcemap: true,    // Helpful for debugging
    define: {
        'process.env.NODE_ENV': '"production"' // Define environment
    }
}).catch(() => process.exit(1));
