describe('Security', () => {
    test('should use HTTPS instead of HTTP', () => {
      const manifest = require('./manifest.json');
      const urls = Object.values(manifest.content_scripts[0].matches);
      urls.forEach(url => {
        expect(url.startsWith('https://')).toBe(true);
      });
    });
  
    test('should not use any vulnerable dependencies', () => {
      const packageJson = require('./package.json');
      const vulnerableDeps = [
        'lodash',
        'jquery',
        'request',
        'moment',
        // add any other vulnerable dependencies here
      ];
      const deps = Object.keys(packageJson.dependencies);
      vulnerableDeps.forEach(dep => {
        expect(deps).not.toContain(dep);
      });
    });
  
    test('should not have any known security vulnerabilities', async () => {
      const { stdout } = await exec('npm audit --json');
      const auditData = JSON.parse(stdout);
      const { metadata, advisories } = auditData;
      expect(metadata.vulnerabilities.total).toBe(0);
      expect(advisories).toHaveLength(0);
    });
  });
  