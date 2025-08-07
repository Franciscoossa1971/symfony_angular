import { ComponentFixture, TestBed } from '@angular/core/testing';

import { ProductoComponente } from './producto-componente';

describe('ProductoComponente', () => {
  let component: ProductoComponente;
  let fixture: ComponentFixture<ProductoComponente>;

  beforeEach(async () => {
    await TestBed.configureTestingModule({
      imports: [ProductoComponente]
    })
    .compileComponents();

    fixture = TestBed.createComponent(ProductoComponente);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
