using MySql.Data.MySqlClient;
using System;
using System.Collections.Generic;
using System.ComponentModel;
using System.Data;
using System.Drawing;
using System.Linq;
using System.Text;
using System.Threading.Tasks;
using System.Windows.Forms;
using System.IO;
using static System.Windows.Forms.VisualStyles.VisualStyleElement;
using System.Data.SqlClient;

namespace AdminLibrary
{
    public partial class Form1 : Form
    {


        private string connectionString;

        private string imagePath;


        public Form1()
        {
            InitializeComponent();
            // Initialize the connection string using the builder
            MySqlConnectionStringBuilder builder = new MySqlConnectionStringBuilder
            {
                Server = "localhost",
                Database = "database_users",
                UserID = "root",
                Password = ""
            };
            connectionString = builder.ConnectionString;
        }

    

        private void button1_Click(object sender, EventArgs e)
        {
            FormA.Visible = false;
            FormB.Visible = false;
            FormC.Visible = false;
            FormD.Visible = false;

            // Show the panel for Button 1
            FormA.Visible = true;
        }

        private void button2_Click(object sender, EventArgs e)
        {
            FormA.Visible = false;
            FormB.Visible = false;
            FormC.Visible = false;
            FormD.Visible = false;

            // Show the panel for Button 1
            FormB.Visible = true;
        }

        private void button3_Click(object sender, EventArgs e)
        {
            FormA.Visible = false;
            FormB.Visible = false;
            FormC.Visible = false;
            FormD.Visible = false;

            // Show the panel for Button 1
            FormC.Visible = true;
        }

        private void button4_Click(object sender, EventArgs e)
        {
            FormA.Visible = false;
            FormB.Visible = false;
            FormC.Visible = false;
            FormD.Visible = false;

            // Show the panel for Button 1
            FormD.Visible = true;
        }

        private void Form1_Load(object sender, EventArgs e)
        {
            LoadRecord();

        }

        private void button5_Click(object sender, EventArgs e)
        {
            using (OpenFileDialog openFileDialog = new OpenFileDialog())
            {
                openFileDialog.Filter = "Image Files|*.jpg;*.png;*.gif;*.bmp";
                if (openFileDialog.ShowDialog() == DialogResult.OK)
                {
                    imagePath = openFileDialog.FileName; // Store the selected image path
                   uploadPanel.BackgroundImage = Image.FromFile(imagePath);
                  uploadPanel.BackgroundImageLayout = ImageLayout.Stretch;
                }
            }

        }

        private void button6_Click(object sender, EventArgs e)
        {
            try
            {
                if (!string.IsNullOrEmpty(imagePath))
                {
                    // Specify the folder where you want to save the uploaded images
                    string uploadFolder = "C:\\Pics"; // Update this path to your desired folder

                    // Ensure the folder exists; create it if not
                    if (!Directory.Exists(uploadFolder))
                    {
                        Directory.CreateDirectory(uploadFolder);
                    }

                    // Copy the uploaded image to the specified folder
                    string imageName = Path.GetFileName(imagePath);
                    string destinationPath = Path.Combine(uploadFolder, imageName);
                    File.Copy(imagePath, destinationPath, true);

                    using (SqlConnection connection = new SqlConnection(connectionString))
                    {
                        connection.Open();

                        // Read the copied image file into a byte array
                        byte[] imageBytes = File.ReadAllBytes(destinationPath);

                        // Insert the image into the database
                        string insertQuery = "INSERT INTO images (ImageData, image_name) VALUES (@Image, @ImageName)";
                        using (SqlCommand cmd = new SqlCommand(insertQuery, connection))
                        {
                            cmd.Parameters.AddWithValue("@Image", imageBytes);
                            cmd.Parameters.AddWithValue("@ImageName", imageName);
                            cmd.ExecuteNonQuery();
                            MessageBox.Show("Image uploaded and saved to the database.");
                        }
                    }
                }
                else
                {
                    MessageBox.Show("Please select an image first.");
                }
            }
            catch (Exception ex)
            {
                MessageBox.Show("Error: " + ex.Message);
            }
        }
    
    
    
    
    

        private void pictureBoxImage_Click(object sender, EventArgs e)
        {

        }

        private void dataGridView1_CellContentClick(object sender, DataGridViewCellEventArgs e)
        {



        }

        private void dataGridView2_CellContentClick(object sender, DataGridViewCellEventArgs e)
        {
       
    




        }

        public void LoadRecord()
        {
       
  
        }

        private void panel4_Paint(object sender, PaintEventArgs e)
        {

        }

        private void pictureBox1_Click(object sender, EventArgs e)
        {

        }
    }
    }
    
    

 