module.exports = {
    browser: "firefox",
    proxy: "https://the7ofdiamonds.development",
    open: 'external',
    ws: true,
    cors: true,
    files: ['**/*.php', '**/*.js', '**/*.css'],
    https: {
        cert: '/Users/jamellyons/Documents/J_C_LYONS_ENTERPRISES_LLC/THE7OFDIAMONDS.TECH/Development/nginx/ssl/certs/nginx-selfsigned.crt',
        key: '/Users/jamellyons/Documents/J_C_LYONS_ENTERPRISES_LLC/THE7OFDIAMONDS.TECH/Development/nginx/ssl/private/nginx-selfsigned.key',
    },
    middleware: [
        function (req, res, next) {
          res.setHeader('Access-Control-Allow-Origin', '*');
          next();
        }
      ],
    snippetOptions: {
        rule: {
            match: /<\/head>/i,
            fn: function (snippet, match) {
                return snippet + match;
            },
        },
    },
};