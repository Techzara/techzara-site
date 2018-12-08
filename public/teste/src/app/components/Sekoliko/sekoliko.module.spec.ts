import { SekolikoModule } from './sekoliko.module';

describe('SekolikoModule', () => {
  let sekolikoModule: SekolikoModule;

  beforeEach(() => {
    sekolikoModule = new SekolikoModule();
  });

  it('should create an instance', () => {
    expect(sekolikoModule).toBeTruthy();
  });
});
