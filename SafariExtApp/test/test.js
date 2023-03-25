const assert = require('assert');

console.log(safari); // Check if safari object is defined

describe('Security', function() {
    test('should not use any vulnerable dependencies', () => {
      const manifest = safari.extension.baseURI + 'manifest.json';
      const content = safari.extension.secureSettings.content;
  
      retire.scanNode(content, function (result) {
        expect(result.length).toBe(0);
      });
    });
  });
