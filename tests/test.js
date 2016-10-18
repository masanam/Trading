describe('retries', function() {
  // Retry all tests in this suite up to 4 times
  this.retries(4);
  
  beforeEach(function () {
    browser.get('http://www.yahoo.com');
  });
  
  it('should succeed on the 3rd try', function () {
    // Specify this test to only retry up to 2 times
    this.retries(2);
    expect($('.foo').isDisplayed()).to.eventually.be.true;
  });
});