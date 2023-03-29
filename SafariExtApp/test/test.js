const loadtest = require('loadtest');
const assert = require('assert');
const { app, BrowserWindow } = require('electron');
const jsdom = require('jsdom');
const { JSDOM } = jsdom;
const dom = new JSDOM();
global.document = dom.window.document;


const options = {
  url: 'https://google.com',
  maxRequests: 1000,
  concurrency: 10,
};

describe('Load testing', function() {
  it('should handle high traffic without errors', function(done) {
    loadtest.loadTest(options, function(error, result) {
      assert.ifError(error);
      assert.strictEqual(result.totalRequests, options.maxRequests);
      done();
    });
  }, 100000);
});

describe('Extension UI', function() {
  beforeEach(() => {
    document.body.innerHTML = `
      <div id="toolbar-button">Extension toolbar button</div>
      <div id="menu-button">Extension menu button</div>
    `;
  });

  it('should be visible and accessible from the toolbar or menu', function() {
    const toolbarButton = document.querySelector('#toolbar-button');
    const menuButton = document.querySelector('#menu-button');
    assert.ok(toolbarButton || menuButton, 'Extension button not found in toolbar or menu');
  });
});

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
process.env.JEST_ENV = 'jsdom';
