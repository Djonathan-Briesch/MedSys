import { useState, useEffect } from "react";
import { Header } from "../../components/Header";
import { DoctorCard } from "../../components/DoctorCard";
import {
  PageContainer,
  Content,
  SearchContainer,
  SearchInput,
  SearchIcon,
  DoctorsGrid
} from "./styles";


const mockDoctors = [
  { id: 1, name: "Dr. Carlos Silva", specialty: "Cardiologia", price: 250.00 },
  { id: 2, name: "Dra. Ana Oliveira", specialty: "Dermatologia", price: 200.00 },
  { id: 3, name: "Dr. Marcos Souza", specialty: "Ortopedia", price: 220.00 },
  { id: 4, name: "Dra. Juliana Costa", specialty: "Pediatria", price: 180.00 },
  { id: 5, name: "Dr. Roberto Almeida", specialty: "Neurologia", price: 300.00 },
  { id: 6, name: "Dra. Fernanda Lima", specialty: "Ginecologia", price: 230.00 },
];

export const Home = () => {
  const [searchTerm, setSearchTerm] = useState("");
  const [filteredDoctors, setFilteredDoctors] = useState(mockDoctors);


// TODO: FAZR CONSULTA COM API
  useEffect(() => {
    const results = mockDoctors.filter(doctor =>
      doctor.name.toLowerCase().includes(searchTerm.toLowerCase())
    );
    setFilteredDoctors(results);
  }, [searchTerm]);

  return (
    <PageContainer>
      <Header />
      <Content>
        <SearchContainer>
          <SearchInput
            type="text"
            placeholder="Pesquisar médico pelo nome..."
            value={searchTerm}
            onChange={(e) => setSearchTerm(e.target.value)}
          />
          <SearchIcon>🔍</SearchIcon>
        </SearchContainer>

        <DoctorsGrid>
          {filteredDoctors.map(doctor => (
            <DoctorCard key={doctor.id} doctor={doctor} />
          ))}
        </DoctorsGrid>
      </Content>
    </PageContainer>
  );
};