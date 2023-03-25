const loadtest = require('loadtest');
const assert = require('assert');

const options = {
  url: 'https://google.com', // Replace with your extension's URL
  maxRequests: 1000, // Total number of requests to send
  concurrency: 10, // Number of requests to send concurrently
};

describe('Load testing', function() {
  it('should handle high traffic without errors', function(done) {
    loadtest.loadTest(options, function(error, result) {
      assert.ifError(error);
      assert.strictEqual(result.totalRequests, options.maxRequests);
      done();
    });
  }, 100000); // increase timeout to 10000ms
});
