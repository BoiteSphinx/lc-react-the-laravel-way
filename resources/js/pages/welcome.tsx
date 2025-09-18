import { Suspense, use, useEffect, useState } from "react";
import { Container } from "@/components/Container";
import { Header } from "@/components/Header";
import { NewPuppyForm } from "@/components/NewPuppyForm";
import { PageWrapper } from "@/components/PageWrapper";
import { PuppiesList } from "@/components/PuppiesList";
import { Search } from "@/components/Search";
import { ShortList } from "@/components/ShortList";

import { Puppy } from "@/types";
import { LoaderCircle } from "lucide-react";
import { getPuppies } from "@/queries";
import { ErrorBoundary } from "react-error-boundary";

export default function App() {
  return (
    <PageWrapper>
      <Container>
        <Header />
        <ErrorBoundary fallbackRender={({ error }) => (
          <div className="mt-12 bg-red-100 p-6 shadow ring ring-black/5">
            <p className="text-red-500">{error.message}: {error.details}</p>
          </div>
        )}>
          <Suspense
            fallback={
              <div className="mt-12 grid h-48 place-items-center">
                <LoaderCircle className="animate-spin stroke-slate-300" />
              </div>
            }
          >
            <Main />
          </Suspense>

        </ErrorBoundary>
      </Container>
    </PageWrapper>
  );
}

const puppyPromise = getPuppies()

function Main() {
  const apiPuppies = use(puppyPromise)
  const [searchQuery, setSearchQuery] = useState<string>("")
  const [puppies, setPuppies] = useState<Puppy[]>(apiPuppies)

  return (
    <main>
      <div className="mt-24 grid gap-8 sm:grid-cols-2">
        <Search searchQuery={searchQuery} setSearchQuery={setSearchQuery} />

        <ShortList puppies={puppies} setPuppies={setPuppies} />
      </div>
      <PuppiesList searchQuery={searchQuery} puppies={puppies} setPuppies={setPuppies} />

      <NewPuppyForm puppies={puppies} setPuppies={setPuppies} />

    </main>
  );
}
