const { readFile, writeFile, unlink } = require('fs').promises;
const { version } = require('./package.json');

(async function exec() {
  /// J4
  let xml = await readFile('./src/invalidatecache/mod_invalidatecache.xml', {
    encoding: 'utf8',
  });
  xml = xml.replace(/{{version}}/g, version);

  await writeFile('./mod_invalidatecache.xml', xml, { encoding: 'utf8' });

  const zip = new (require('adm-zip'))();
  zip.addLocalFolder('src/invalidatecache/media', 'media');
  zip.addLocalFolder('./src/invalidatecache/services', 'services');
  zip.addLocalFolder('src/invalidatecache/src', 'src');
  zip.addLocalFolder('src/invalidatecache/tmpl', 'tmpl');
  zip.addLocalFile('mod_invalidatecache.xml', false);

  zip.writeZip(`dist/j4/mod_invalidatecache_${version}.zip`);

  await unlink('./mod_invalidatecache.xml')

  /// J3
  xml = await readFile('./src/j3.x/mod_invalidatecache.xml', {
    encoding: 'utf8',
  });
  xml = xml.replace(/{{version}}/g, version);

  await writeFile('./mod_invalidatecache.xml', xml, { encoding: 'utf8' });

  const zip2 = new (require('adm-zip'))();
  zip2.addLocalFolder('src/j3.x/media', 'media');
  zip2.addLocalFolder('src/j3.x/tmpl', 'tmpl');

  zip2.addLocalFile('./src/j3.x/helper.php', false);
  zip2.addLocalFile('mod_invalidatecache.xml', false);
  zip2.addLocalFile('./src/j3.x/mod_invalidatecache.php', false);

  zip2.writeZip(`dist/j3/mod_invalidatecache_${version}.zip`);

  await unlink('./mod_invalidatecache.xml')
})();
