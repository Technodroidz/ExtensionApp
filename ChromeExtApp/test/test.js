const { exec } = require('child_process');

describe('Security', () => {
  test('should use HTTPS instead of HTTP', () => {
    const manifest = require('../manifest.json');
    const urls = Object.values(manifest.content_scripts[0].matches);
    urls.forEach(url => {
      expect(url.startsWith('https://')).toBe(true);
    });
  });

});
