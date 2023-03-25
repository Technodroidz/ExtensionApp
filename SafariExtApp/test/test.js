const assert = require('assert');
const jsdom = require('jsdom-global');

// Call jsdom-global before running tests to mock the Safari environment
jsdom();

describe('Security', function() {
    test('should not use any vulnerable dependencies', () => {
      const manifest = './package.json'; // Update with the path to your manifest file
      const xhr = new XMLHttpRequest();
      xhr.open('GET', manifest, false);
      xhr.send(null);
      const content = JSON.parse(xhr.responseText);
  
      retire.scanNode(content, function (result) {
        expect(result.length).toBe(0);
      });
    });
  });
