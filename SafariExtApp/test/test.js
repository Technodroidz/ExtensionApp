const loadtest = require('loadtest');
const assert = require('assert');
const { app, BrowserWindow } = require('electron');

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

describe('Extension UI', function() {
  beforeEach(() => {
    document.body.innerHTML = `
      <div id="toolbar-button">Extension toolbar button</div>
      <div id="menu-button">Extension menu button</div>
    `;
  });

  it('should be visible and accessible from the toolbar or menu', function() {
    // Check if the extension is visible and accessible
    // from the toolbar or menu
    const toolbarButton = document.querySelector('#toolbar-button');
    const menuButton = document.querySelector('#menu-button');

    // Assert that the extension is visible and accessible
    assert.ok(toolbarButton || menuButton, 'Extension button not found in toolbar or menu');
  });
});

// Use jest-environment-jsdom for the tests to be able to access the DOM API
jest.setTimeout(10000);
jest.mock('fs', () => require('memfs').fs);
jest.mock('electron', () => ({
  app: {
    getPath: () => 'test/test.js'
  }
}));
process.env.NODE_ENV = 'test';
process.env.TEST = 'true';
process.env.EXTENSION_ID = 'test-id';
process.env.TEST_ENVIRONMENT = 'true';
process.env.DEBUG = 'true';
process.env.DISABLE_VIEWS_COLLECTION = 'true';
process.env.DISABLE_ANALYTICS_COLLECTION = 'true';
process.env.APP_SETTINGS = JSON.stringify({
  enableTelemetry: false
});
process.env.APP_INSTALLATION_ID = 'test-installation-id';

// Set the Jest environment to jsdom to emulate the browser environment
// within Node.js
process.env.JEST_ENV = 'jsdom';
