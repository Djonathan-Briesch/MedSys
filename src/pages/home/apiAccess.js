export async function fetchDoctors() {
  try {
    const response = await fetch("http://localhost:8000/controller/UserController.php?type=DOCTOR");
    if (!response.ok) throw new Error("Erro ao buscar médicos");
    
    const data = await response.json();

    const doctorsWithRandomPrice = data.map(doc => ({
      ...doc,
      price: Math.floor(Math.random() * (500 - 100 + 1)) + 100,
    }));

    return doctorsWithRandomPrice;
  } catch (error) {
    console.error("Erro no fetchDoctors:", error);
    return [];
  }
}
