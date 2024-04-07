module.exports = {
  "presets": [
    ["@babel/preset-react", { "runtime": "automatic" }],
    [
      "@babel/preset-env",
      {
        "targets": {
          "browsers": ["last 2 versions", "> 1%"]
        },
        "useBuiltIns": "entry",
        "corejs": 3
      }
    ]
  ],
  "plugins": [
    // Add any additional plugins you may need
  ]
};
