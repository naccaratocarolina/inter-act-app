import { async, ComponentFixture, TestBed } from '@angular/core/testing';
import { IonicModule } from '@ionic/angular';

import { NewArticlePage } from './new-article.page';

describe('NewArticlePage', () => {
  let component: NewArticlePage;
  let fixture: ComponentFixture<NewArticlePage>;

  beforeEach(async(() => {
    TestBed.configureTestingModule({
      declarations: [ NewArticlePage ],
      imports: [IonicModule.forRoot()]
    }).compileComponents();

    fixture = TestBed.createComponent(NewArticlePage);
    component = fixture.componentInstance;
    fixture.detectChanges();
  }));

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
