<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Movie;

class MovieSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        // Obtener la ruta del archivo CSV
        $csvFilePath = storage_path('app/movies.csv');

        if (Movie::count() === 0) {
            // Abrir el archivo CSV
            if (($handle = fopen($csvFilePath, 'r')) !== false) {
                // Lee la primera línea y descártala
                fgetcsv($handle);

                // Iterar sobre cada fila del archivo CSV
                while (($data = fgetcsv($handle, 1000, ',')) !== false) {
                    // Crear un nuevo registro de película con los datos de la fila
                    Movie::create([
                        'title' => $data[1],
                        'genre' => $data[2],
                        'description' => $data[3],
                        'director' => $data[4],
                        'year' => $data[6],
                    ]);
                }

                // Cerrar el archivo CSV
                fclose($handle);
            }
        } else {
            if (($handle = fopen($csvFilePath, 'r')) !== false) {
                // Lee la primera línea y descártala
                fgetcsv($handle);

                // Iterar sobre cada fila del archivo CSV
                while (($data = fgetcsv($handle, 1000, ',')) !== false) {
                    if (!Movie::where('title', $data[1])->exists()) {
                        // Crear un nuevo registro de película con los datos de la fila
                        Movie::create([
                            'title' => $data[1],
                            'genre' => $data[2],
                            'description' => $data[3],
                            'director' => $data[4],
                            'year' => $data[6],
                        ]);
                    }
                }

                // Cerrar el archivo CSV
                fclose($handle);
            }
        }
        
    }
}
