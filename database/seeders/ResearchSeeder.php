<?php

namespace Database\Seeders;

use App\Models\Research;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class ResearchSeeder extends Seeder
{
  /**
   * Run the database seeds.
   */
  public function run(): void
  {
    $research = array(
      'user_id' => '1','type_id' => '2','status_id' => '2','progress_id' => '3','nature_id' => '3','domain_id' => '1','category_code' => '1','title' => 'Investigation of Fig Leaf Extract as Novel Environmentally friendly Antiscalent for CaCO3 Calcareous Deposits','publishing_date' => '2008-09-01','publisher' => 'Elsevier','isbn' => NULL,'magazine' => 'Elsevier','edition' => '2','publication_location' => '18','summary' => 'Mineral scales were deposited from a CaCl2 brine solution (0.7 M NaCl, 0.0025 M NaHCO3, 0.028 M Na2SO4 and 0.01 M CaCl2) by cathodic polarization of the steel surface to −0.9 V (vs. SCE) at 40°C. Nucleation, crystal growth and total coverage of the surface regions were characterized by different impedance behaviour. The effect of fig leaves (Ficus carica L.) extract as an antiscalent in an alkaline CaCl2 brine solution was studied using chronoamperometry, electrochemical impedance spectroscopy (EIS) techniques and conductivity measurements, in conjunction with microscopic examination. EIS measurements were carried out at the open circuit potential and −0.9 V (vs. SCE) to investigate the antiscale function of the extracts of fig leaves. The surface area occupied by the scale deposits decreases with increasing fig leaf extract concentrations and the critical concentration required to inhibit scale formation was 75 ppm. Fig leaf extract was found to impede CaCO3 supersaturation and increase the time of nucleation. The data indicated that fig leaf extract could be used safely as an antiscalent.','lang_id' => '2','publishing_url' => 'https://doi.org/10.1016/j.desal.2007.12.005','key_words' => 'scales formation investigate fig','pages_number' => '15','created_at' => '2023-11-25 09:56:45','updated_at' => '2023-11-25 09:56:45'
    );
    Research::create($research);
  }
}
