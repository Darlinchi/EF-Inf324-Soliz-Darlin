using System;
using System.Drawing;
using System.Windows.Forms;

namespace WindowsFormsApplication4
{
    public partial class Form1 : Form
    {
        public Form1()
        {
            InitializeComponent();
        }

        private void button1_Click(object sender, EventArgs e)
        {
            // Cargar imagen
            openFileDialog1.Filter = "Archivos JPG|*.jpg|Archivos PNG|*.png";
            if (openFileDialog1.ShowDialog() == DialogResult.OK)
            {
                Bitmap bmp = new Bitmap(openFileDialog1.FileName);
                pictureBox1.Image = bmp;
            }
        }

        private void button2_Click(object sender, EventArgs e)
        {
            if (pictureBox1.Image == null)
            {
                MessageBox.Show("Por favor, carga una imagen primero.");
                return;
            }

            // Procesar imagen para resaltar animales
            Bitmap originalImage = new Bitmap(pictureBox1.Image);
            Bitmap highlightedImage = HighlightAnimals(originalImage);

            // Mostrar la imagen resaltada en pictureBox2
            pictureBox2.Image = highlightedImage;
        }

        private Bitmap HighlightAnimals(Bitmap image)
        {
            // Crear copia de la imagen original
            Bitmap resultImage = new Bitmap(image.Width, image.Height);

            // Umbrales de color para detectar animales (simulación)
            int rMin = 60, rMax = 160;
            int gMin = 30, gMax = 120;
            int bMin = 10, bMax = 90;

            for (int x = 0; x < image.Width; x++)
            {
                for (int y = 0; y < image.Height; y++)
                {
                    Color pixelColor = image.GetPixel(x, y);

                    // Detectar si el píxel cumple con los rangos de color
                    if (pixelColor.R >= rMin && pixelColor.R <= rMax &&
                        pixelColor.G >= gMin && pixelColor.G <= gMax &&
                        pixelColor.B >= bMin && pixelColor.B <= bMax)
                    {
                        // Pintar área detectada en rojo
                        resultImage.SetPixel(x, y, Color.Red);
                    }
                    else
                    {
                        // Copiar el color original
                        resultImage.SetPixel(x, y, pixelColor);
                    }
                }
            }

            return resultImage;
        }
    }
}
