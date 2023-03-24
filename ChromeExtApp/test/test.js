const { exec } = require('child_process');

describe('Security', () => {
  test('should use HTTPS instead of HTTP', () => {
    const manifest = require('../manifest.json');
    const urls = Object.values(manifest.content_scripts[0].matches);
    urls.forEach(url => {
      expect(url.startsWith('https://')).toBe(true);
    });
  });
  
  test('should not use any vulnerable dependencies', () => {
    const packageJson = require('../package.json');
    const vulnerableDeps = ['lodash','request','moment'];  // add any other vulnerable dependencies here   
    const deps = Object.keys(packageJson.dependencies);
    vulnerableDeps.forEach(dep => {
      expect(deps).not.toContain(dep);
    });
  });
});
