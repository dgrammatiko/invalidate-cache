const pakage = require('../../package.json');

module.exports = () => {
  return {
    url: pakage.data.siteUrl,
    repo: pakage.data.repo,
    version: pakage.version
  };
}
