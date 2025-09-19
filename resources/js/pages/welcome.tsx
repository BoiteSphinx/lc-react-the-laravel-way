import { useState } from "react";
import { Container } from "@/components/Container";
import { Header } from "@/components/Header";
import { NewPuppyForm } from "@/components/NewPuppyForm";
import { PageWrapper } from "@/components/PageWrapper";
import { PuppiesList } from "@/components/PuppiesList";
import { Search } from "@/components/Search";
import { ShortList } from "@/components/ShortList";

import { Puppy, SharedData } from "@/types";
import { usePage } from "@inertiajs/react";

export default function App({ puppies }: { puppies: Puppy[] }) {
  return (
    <PageWrapper>
      <Container>
        <Header />
        <Main pups={puppies} />
      </Container>
    </PageWrapper>
  );
}

function Main({ pups }: { pups: Puppy[] }) {
  const [searchQuery, setSearchQuery] = useState<string>("")
  const [puppies, setPuppies] = useState<Puppy[]>(pups)
  const { auth } = usePage<SharedData>().props

  return (
    <main>
      <div className="mt-24 grid gap-8 sm:grid-cols-2">
        <Search searchQuery={searchQuery} setSearchQuery={setSearchQuery} />

        {auth.user && (
          <ShortList puppies={puppies} setPuppies={setPuppies} />
        )}
      </div>
      <PuppiesList searchQuery={searchQuery} puppies={puppies} setPuppies={setPuppies} />

      <NewPuppyForm puppies={puppies} setPuppies={setPuppies} />

    </main>
  );
}
