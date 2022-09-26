module.exports = {
  content: [
    'templates/**/*.html.twig',
    'assets/**/*.js',
  ],
  theme: {
    extend: {},
  },
  plugins: [],
  safelist: [
    {
      pattern: /./, // the "." means "everything"
    },
  ]
};
