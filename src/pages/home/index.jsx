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

import { fetchDoctors } from "./apiAccess";

export const Home = () => {
  const [searchTerm, setSearchTerm] = useState("");
  const [doctors, setDoctors] = useState([]);
  const [filteredDoctors, setFilteredDoctors] = useState([]);

  useEffect(() => {
    async function loadDoctors() {
      const doctorsFromService = await fetchDoctors();
      setDoctors(doctorsFromService);
      setFilteredDoctors(doctorsFromService);
    }
    loadDoctors();
  }, []);

  useEffect(() => {
    const results = doctors.filter(doctor =>
      doctor.name.toLowerCase().includes(searchTerm.toLowerCase())
    );
    setFilteredDoctors(results);
  }, [searchTerm, doctors]);

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
          {filteredDoctors.length === 0 ? (
            <p>Nenhum médico encontrado.</p>
          ) : (
            filteredDoctors.map(doctor => (
              <DoctorCard key={doctor.id} doctor={doctor} />
            ))
          )}
        </DoctorsGrid>
      </Content>
    </PageContainer>
  );
};
