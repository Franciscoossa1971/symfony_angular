import { Component, OnInit } from '@angular/core';
import { ProductoService } from '../../services/producto/producto';


interface Producto {
  id: number;
  nombre: string;
  precio: number;
  cantidad: number;
}

@Component({
  selector: 'app-producto-componente',
  imports: [CommonModule],
  templateUrl: './producto-componente.html',
  styleUrl: './producto-componente.css'
})
export class ProductoComponente implements OnInit {

  productos: Producto[] = [];

  constructor(private productoService: ProductoService) { }

  ngOnInit(): void {
    this.loadProductos();
  }

  // Cargar todos los productos
  loadProductos(): void {
    this.productoService.getProductos().subscribe(
      (data) => {
        this.productos = data;
      },
      (error) => {
        console.error('Error al obtener los productos', error);
      }
    );
  }
} import { CommonModule } from '@angular/common';

