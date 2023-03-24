const { exec } = require('child_process');
import http from 'k6/http';
import { check } from 'k6';

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
    const vulnerableDeps = ['lodash','jquery','request','moment'];  // add any other vulnerable dependencies here   
    const deps = Object.keys(packageJson.dependencies);
    vulnerableDeps.forEach(dep => {
      expect(deps).not.toContain(dep);
    });
  });

  // load testing for scalability and performance
  export let options = {
    vus: 10,
    duration: '30s',
  };

  export default function () {
    const response = http.get('https://www.example.com');
    check(response, {
      'status is 200': (r) => r.status === 200,
    });
  }
});
