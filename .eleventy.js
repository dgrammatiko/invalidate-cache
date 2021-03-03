const pluginSyntaxHighlight = require("@11ty/eleventy-plugin-syntaxhighlight");
let Nunjucks = require('nunjucks');
// const htmlmin = require("html-minifier");
// const codepenIt = require("11ty-to-codepen");

module.exports = function (eleventyConfig) {
  // eleventyConfig.addPassthroughCopy({ "site/_includes/css": "css" });
  eleventyConfig.addPassthroughCopy({ "site/images": "images" });
  eleventyConfig.addPassthroughCopy({ "dist": "dist" });
  eleventyConfig.setDataDeepMerge(true);

  let nunjucksEnvironment = new Nunjucks.Environment(new Nunjucks.FileSystemLoader('./site/_includes'));
  // nunjucksRender.nunjucks.configure(['./templates/']);
  eleventyConfig.setLibrary('njk', nunjucksEnvironment)

  // Filter source file names using a glob
  eleventyConfig.addCollection("docs", function (collection) {
    // Also accepts an array of globs!
    return collection.getFilteredByGlob(['site/docs/*.md']);
  });

  // eleventyConfig.addTransform("htmlmin", function (content, outputPath) {
  //   if (outputPath.endsWith(".html")) {
  //     let minified = htmlmin.minify(content, {
  //       useShortDoctype: true,
  //       removeComments: true,
  //       collapseWhitespace: true,
  //     });
  //     return minified;
  //   }
  //   return content;
  // });


  /* Markdown Plugins */
  let markdownIt = require("markdown-it");
  let markdownItAnchor = require("markdown-it-anchor");
  let options = {
    html: true,
    breaks: true,
    linkify: true,
  };
  let opts = {
    permalink: true,
    permalinkClass: "direct-link",
    permalinkSymbol: "🔗",
  };

  eleventyConfig.setLibrary(
    "md",
    markdownIt(options).use(markdownItAnchor, opts)
  );

  // eleventyConfig.addPairedShortcode("codepen", codepenIt);

  return {
    pathPrefix: "/",
    passthroughFileCopy: true,
    dir: {
      data: `_data`,
      input: 'site',
      includes: `_includes`,
      layouts: `_includes`,
      output: '_site',
    },
  };
};
