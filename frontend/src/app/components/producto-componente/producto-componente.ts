import { Component, OnInit } from '@angular/core';
import { ProductoService } from '../../services/producto/producto';
import { CommonModule } from '@angular/common';
import { FormBuilder, FormGroup, ReactiveFormsModule, Validators } from '@angular/forms';

interface Producto {
  id: number;
  nombre: string;
  precio: number;
  cantidad: number;
}

@Component({
  selector: 'app-producto-componente',
  imports: [CommonModule, ReactiveFormsModule],
  templateUrl: './producto-componente.html',
  styleUrl: './producto-componente.css'
})
export class ProductoComponente implements OnInit {

  productos: Producto[] = [];
  productoForm: FormGroup;
  editando: boolean = false;
  productoSeleccionado: Producto | null = null;

  constructor(
    private productoService: ProductoService,
    private fb: FormBuilder
  ) {
    this.productoForm = this.fb.group({
      nombre: ['', [Validators.required, Validators.minLength(3)]],
      precio: [0, [Validators.required, Validators.min(0.01)]],
      cantidad: [0, [Validators.required, Validators.min(1), Validators.pattern(/^\d+$/)]],
    });
  }

  ngOnInit(): void {
    this.cargarProductos();
  }

  cargarProductos(): void {
    this.productoService.getProductos().subscribe((data) => {
      this.productos = data;
    });
  }

  crearProducto(): void {
    if (this.productoForm.valid) {
      this.productoService
        .crearProducto(this.productoForm.value)
        .subscribe(() => {
          this.productoForm.reset();
          this.cargarProductos();
        });
    }
  }

  seleccionarProducto(producto: Producto): void {
    this.editando = true;
    this.productoSeleccionado = producto;
    this.productoForm.patchValue(producto);
  }

  actualizarProducto(): void {
    if (this.productoSeleccionado && this.productoForm.valid) {
      this.productoService
        .actualizarProducto(this.productoSeleccionado.id!, this.productoForm.value)
        .subscribe(() => {
          this.editando = false;
          this.productoSeleccionado = null;
          this.productoForm.reset();
          this.cargarProductos();
        });
    }
  }

  cancelarEdicion(): void {
    this.editando = false;
    this.productoSeleccionado = null;
    this.productoForm.reset();
  }

  eliminarProducto(id: number): void {
    this.productoService.eliminarProducto(id).subscribe(() => {
      this.cargarProductos();
    });
  }
}

