import { async, ComponentFixture, TestBed } from '@angular/core/testing';
import { IonicModule } from '@ionic/angular';

import { RedirPagePage } from './redir-page.page';

describe('RedirPagePage', () => {
  let component: RedirPagePage;
  let fixture: ComponentFixture<RedirPagePage>;

  beforeEach(async(() => {
    TestBed.configureTestingModule({
      declarations: [ RedirPagePage ],
      imports: [IonicModule.forRoot()]
    }).compileComponents();

    fixture = TestBed.createComponent(RedirPagePage);
    component = fixture.componentInstance;
    fixture.detectChanges();
  }));

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
