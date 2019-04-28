const fs = require('fs');
const parser = require('gettext-parser');
const glob = require('glob');

const translationsDir = './translations';
const langRegex = /\.\/translations\/([a-z]{2})\.po/;
poFilePaths = glob.sync(`${translationsDir}/*.po`);

try {
  poFilePaths.forEach((poFilePath) => {
    const matches = poFilePath.match(langRegex);
    if (!matches || matches.length != 2) {
      console.log(`Skipping file ${poFilePath}`);
      return;
    }
    const languageName = matches[1];
    const poFileContent = fs.readFileSync(poFilePath, 'utf8');
    const translations = parser.po.parse(poFileContent);

    const outputFilePath = `${translationsDir}/${languageName}.json`;
    fs.writeFileSync(outputFilePath, JSON.stringify(translations, null, 2));

    console.log(`Processed language files for language '${languageName}'`);
  });

} catch (err) {
  console.log('Error!', err);
}
