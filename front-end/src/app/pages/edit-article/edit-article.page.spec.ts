import { async, ComponentFixture, TestBed } from '@angular/core/testing';
import { IonicModule } from '@ionic/angular';

import { EditArticlePage } from './edit-article.page';

describe('EditArticlePage', () => {
  let component: EditArticlePage;
  let fixture: ComponentFixture<EditArticlePage>;

  beforeEach(async(() => {
    TestBed.configureTestingModule({
      declarations: [ EditArticlePage ],
      imports: [IonicModule.forRoot()]
    }).compileComponents();

    fixture = TestBed.createComponent(EditArticlePage);
    component = fixture.componentInstance;
    fixture.detectChanges();
  }));

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
