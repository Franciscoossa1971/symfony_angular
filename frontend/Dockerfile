FROM node:20.19

# Crear el directorio de trabajo
WORKDIR /app

# Copiar archivos de dependencias y instalar
COPY package*.json ./
RUN npm install

# Copiar el resto del código
COPY . .

# Exponer el puerto usado por Angular
EXPOSE 4200

# Comando por defecto
CMD ["npm", "start"]

