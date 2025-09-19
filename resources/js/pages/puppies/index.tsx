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
        <Main inertiaPuppies={puppies} />
      </Container>
    </PageWrapper>
  );
}

function Main({ inertiaPuppies }: { inertiaPuppies: Puppy[] }) {
  const [searchQuery, setSearchQuery] = useState<string>("")
  const [puppies, setPuppies] = useState<Puppy[]>(inertiaPuppies)
  const { auth } = usePage<SharedData>().props

  return (
    <main>
      <div className="mt-24 grid gap-8 sm:grid-cols-2">
        <Search searchQuery={searchQuery} setSearchQuery={setSearchQuery} />

        {auth.user && (
          <ShortList puppies={inertiaPuppies} />
        )}
      </div>
      <PuppiesList searchQuery={searchQuery} puppies={inertiaPuppies} />

      <NewPuppyForm puppies={inertiaPuppies} setPuppies={setPuppies} />

    </main>
  );
}
