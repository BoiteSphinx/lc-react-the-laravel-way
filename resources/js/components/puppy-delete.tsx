import { LoaderCircle, TrashIcon } from "lucide-react";
import { Button } from "@/components/ui/button";
import { Puppy } from "@/types";
import {
  AlertDialog,
  AlertDialogAction,
  AlertDialogCancel,
  AlertDialogContent,
  AlertDialogDescription,
  AlertDialogFooter,
  AlertDialogHeader,
  AlertDialogTitle,
  AlertDialogTrigger
} from "@/components/ui/alert-dialog";
import { Form } from "@inertiajs/react";
import { deleteMethod } from "@/routes/puppies";
import { useState } from "react";
import clsx from "clsx";

export function PuppyDelete({ puppy }: { puppy: Puppy, }) {
  const [open, setOpen] = useState(false)

  return (
    <div>
      <AlertDialog open={open} onOpenChange={setOpen}>
        <AlertDialogTrigger asChild>
          <Button className="group/delete bg-background/30 hover:bg-background" size="icon" variant="secondary" aria-label="Delete puppy">
            <TrashIcon className="size-4 group-hover/delete:stroke-destructive" />
          </Button>
        </AlertDialogTrigger>
        <AlertDialogContent>
          <AlertDialogHeader>
            <AlertDialogTitle>Are you absolutely sure?</AlertDialogTitle>
            <AlertDialogDescription>
              Who in their right mind would delete such a cute puppy? Seriously?
            </AlertDialogDescription>
          </AlertDialogHeader>
          <AlertDialogFooter>
            <AlertDialogCancel>Cancel</AlertDialogCancel>
            <Form
              method="delete"
              action={deleteMethod(puppy.id)}
              options={{
                preserveScroll: true,
              }}
            >
              {({ processing }) => (
                <Button className="disabled:opacity-100 relative" disabled={processing} type="submit">
                  {processing && (
                    <div className="absolute inset-0 grid place-items-center">
                      <LoaderCircle className="size-5 stroke-primary-foreground animate-spin" />
                    </div>
                  )}

                  <span className={clsx(processing && 'invisible')}>Delete {puppy.name}</span>
                </Button>
              )}
            </Form>
          </AlertDialogFooter>
        </AlertDialogContent>
      </AlertDialog>
    </div>
  )
}
