import { Heart, LoaderCircle } from "lucide-react";
import { useState } from "react";
import { Puppy, SharedData } from "../types";
import { toggleLikedStatus } from "../queries";
import { Link, usePage } from "@inertiajs/react";
import { like } from '@/routes/puppies'
import clsx from "clsx";

export function LikeToggle({ puppy }: {
  puppy: Puppy;
}) {
  const [pending, setPending] = useState(false)
  const { auth } = usePage<SharedData>().props

  return (
    <Link
      method="patch"
      href={like(puppy.id)}
      className={clsx('group', !auth.user && 'cursor-not-allowed')}
      disabled={!auth.user}
      preserveScroll
    >
      {pending ? (
        <LoaderCircle className="animate-spin stroke-slate-300" />
      ) : (
        <Heart
          className={
            auth.user && puppy.likedBy.includes(auth.user.id)
            ? 'fill-pink-500 stroke-none'
            : 'stroke-slate-200 group-hover:stroke-slate-300'
          }
        />
      )}
    </Link>
  )
}
