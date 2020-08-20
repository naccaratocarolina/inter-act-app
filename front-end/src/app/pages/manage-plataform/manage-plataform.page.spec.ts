import { async, ComponentFixture, TestBed } from '@angular/core/testing';
import { IonicModule } from '@ionic/angular';

import { ManagePlataformPage } from './manage-plataform.page';

describe('ManagePlataformPage', () => {
  let component: ManagePlataformPage;
  let fixture: ComponentFixture<ManagePlataformPage>;

  beforeEach(async(() => {
    TestBed.configureTestingModule({
      declarations: [ ManagePlataformPage ],
      imports: [IonicModule.forRoot()]
    }).compileComponents();

    fixture = TestBed.createComponent(ManagePlataformPage);
    component = fixture.componentInstance;
    fixture.detectChanges();
  }));

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
